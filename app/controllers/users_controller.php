<?php
/**
 * This file contains the definition of the UsersController class.
 */

/**
 * A controller for signin in/up/out and other user-related stuff.
 * @package Gamespot
 * @subpackage Controllers
 */
class UsersController extends Controller {
  /**
   * {@inheritdoc}
   */
  protected static $before_filters = array(
    'ensure_no_signed_in_user' => [
      'sign_in',
      'sign_up',
      'confirm',
      'forgot_password',
      'reset_password'
    ]
  );

  /**
   * GET /users/sign_in
   * POST /users/sign_in
   * Dispatcher based on the request's type.
   */
  public function sign_in() {
    if ($this->request->is_post()) {
      $this->sign_in_post();
    } else if ($this->request->is_get()) {
      $this->sign_in_get();
    }
  }

  /**
   * GET /users/sign_up
   * POST /users/sign_up
   * Dispatcher based on the request's type.
   */
  public function sign_up() {
    if ($this->request->is_post()) {
      $this->sign_up_post();
    } else if ($this->request->is_get()) {
      $this->sign_up_get();
    }
  }

  /**
   * POST /users/sign_out
   * Sign out a user.
   */
  public function sign_out() {
    Session::sign_out_user();
    redirect('/', ['notice' => 'Signed out successfully.']);
  }

  /**
   * GET /users/profile
   * Display a user's profile. Ensuring that a user is logged in is take care of
   * by the Router.
   */
  public function profile() {
    $ads = Ad::where(['author_id' => $this->current_user->id]);
    $ads = Ad::separate_game_and_accessory($ads);

    $this->game_ads = $ads['game_ads'];
    $this->accessory_ads = $ads['accessory_ads'];
  }

  /**
   * GET /users/settings
   * The settings for a specific user.
   */
  public function settings() {
  }

  /**
   * POST /users/save_settings
   * Save the settings for a specific user and redirect to the settings page
   * with a flash message.
   */
  public function save_settings() {
    $this->current_user->update([
      'first_name' => $this->params['first_name'],
      'last_name' => $this->params['last_name'],
      'email' => $this->params['email']
    ]);

    $this->reload_current_user();
    redirect('/users/settings', ['notice' => 'Updated successfully']);
  }

  /**
   * POST /users/change_password
   * Change the password of the current user.
   */
  public function change_password() {
    $old_hashed = User::hash_password($this->params['old_password']);
    $new_pass = $this->params['new_password'];
    $new_pass_confirmation = $this->params['new_password_confirmation'];

    if ($old_hashed != $this->current_user->hashed_password) {
      $flash = ['error' => 'Wrong password'];
    } else if (empty($new_pass)) {
      $flash = ['error' => "New password can't be empty"];
    } else if ($old_hashed == User::hash_password($new_pass)) {
      $flash = ['error' => 'Password must change'];
    } else if ($new_pass != $new_pass_confirmation) {
      $flash = ['error' => 'Passwords must match'];
    } else {
      $this->current_user->update_password($new_pass);
      $this->reload_current_user();
      $flash = ['notice' => 'Password updated successfully'];
    }

    redirect('/users/settings', $flash);
  }

  /**
   * POST /users/upload_profile_picture
   * Add a profile picture to the current user.
   */
  public function upload_profile_picture() {
    $upload = Upload::create_from_uploaded_file($_FILES['profile_picture']);
    $this->current_user->update_profile_picture($upload);

    redirect(
      '/users/settings',
      ['notice' => 'Profile picture changed successfully.']
    );
  }

  /**
   * GET /users/delete_profile_picture
   * Remove the profile picture for the currently logged in user.
   */
  public function delete_profile_picture() {
    $this->current_user->delete_profile_picture();
    redirect('/users/settings', ['notice' => 'Deleted successfully']);
  }

  /**
   * GET /users/confirm?id=1&token=abc
   * Confirm a user (this action is usually triggered by a link in a
   * confirmation email).
   */
  public function confirm() {
    $user = $this->safe_find('User', $this->params['id']);
    $token = $this->params['token'];

    if ($user->confirmation_token == $token) {
      $user->update(['confirmed' => true, 'confirmation_token' => null]);
      $this->render('users/confirm', ['confirmed' => true]);
    } else {
      $this->render('users/confirm', ['confirmed' => false]);
    }
  }

  /**
   * GET /users/forgot_password
   * POST /users/forgot_password
   * Dispatch to the forgot_password_{get|post} actions.
   */
  public function forgot_password() {
    if ($this->request->is_post()) {
      $this->forgot_password_post();
    } else if ($this->request->is_get()) {
      $this->forgot_password_get();
    }
  }

  /**
   * GET /users/reset_password?id=1&token=abc
   * POST /users/reset_password
   * Dispatch based on the request type.
   */
  public function reset_password() {
    $this->user = $this->safe_find_from_id('User');

    if (!$this->user->is_resetting()) {
      redirect('/', ['error' => "This user isn't resetting his/her password"]);
    } else if ($this->user->reset_token != $this->params['token']) {
      redirect('/', ['error' => 'No matching token']);
    }

    if ($this->request->is_post()) {
      $this->reset_password_post();
    } else if ($this->request->is_get()) {
      $this->reset_password_get();
    }
  }

  /**
   * GET /users/wasnt_me?id=1&token=abc
   * The user received an email with a reset password link but didn't asked for
   * it. Restore her state by clearing her reset token like if she did
   * everything correctly.
   */
  public function wasnt_me() {
    $user = $this->safe_find_from_id('User');

    if ($user->reset_token != $this->params['token']) {
      redirect('/', ['error' => 'No matching tokens']);
    }

    // Restore the user's clean state and redirect to the home page.
    $user->finish_reset_process();
    redirect('/', ['notice' => 'Ok, everything is fine now']);
  }

  /**
   * <b>Filter</b>
   * Ensure there's no signed in user.
   */
  protected function ensure_no_signed_in_user() {
    if (Session::user()) {
      redirect('/', ['error' => 'You are already signed in']);
    }
  }

  /**
   * Display the sign in form.
   */
  private function sign_in_get() {
  }

  /**
   * Sign in the user if sign in infos are correct, otherwise re-render the sign
   * in form with errors displayed.
   */
  private function sign_in_post() {
    $user = User::find_by_attribute('email', $this->params['email']);

    // No user with the given email or wrong password or the user is
    // blocked/unconfirmed: render the sign-in form with an error.
    $this->detect_sign_in_errors($user);

    Session::store_user($user);

    // Take care of when an user is redirected here because she tried to access
    // an authenticated url (see the Router).
    $default_url = $user->can_access_backend() ? '/backend' : '/';
    $new_url = Session::referer_and_reset_or_url($default_url);

    redirect($new_url, ['notice' => 'Successfully logged in.']);
  }

  /**
   * Display the sign up form.
   */
  private function sign_up_get() {
  }

  /**
   * Sign up a user.
   */
  private function sign_up_post() {
    // Redirect to the sign up page if the passwords don't match.
    if ($this->params['password'] != $this->params['password_confirmation']) {
      redirect('/users/sign_up', ['error' => "Passwords don't match"]);
    }

    // Create a new user (which by default is not confirmed).
    $new_user = User::create([
      'email' => $this->params['email'],
      'password' => $this->params['password'],
      'first_name' => $this->params['first_name'],
      'last_name' => $this->params['last_name'],
      'confirmation_token' => User::new_confirmation_token()
    ]);

    // Validate the new user and redirect appropriately.
    if ($new_user->is_valid()) {
      $this->send_confirmation_email_to($new_user);
      $msg = 'Successfully signed up. A confirmation email has been sent to ';
      $msg .= $new_user->email;
      redirect('/', ['notice' => $msg]);
    } else {
      redirect('/users/sign_up', ['error' => $new_user->errors_as_string()]);
    }
  }

  /**
   * Display the 'Forgot password' form.
   */
  private function forgot_password_get() {
  }

  /**
   * Actually send the recovery email.
   */
  private function forgot_password_post() {
    $user = User::find_by_attribute('email', $this->params['recovery_email']);

    if (!$user) {
      redirect('/users/forgot_password', [
        'info' => "No users found with email {$this->params['recovery_email']}"
      ]);
    }

    $user->start_reset_process();
    $this->send_reset_password_email_to($user);

    redirect('/', ['info' => "An email has been sent to {$user->email}"]);
  }

  /**
   * Display the form to reset the password.
   */
  private function reset_password_get() {
  }

  /**
   * Actually reset the password and 'unblock' the user.
   */
  private function reset_password_post() {
    $this->user->update_password($this->params['new_password']);
    $this->user->finish_reset_process();
    Session::store_user($this->user);
    redirect('/', ['notice' => 'Password successfully reset']);
  }

  /**
   * Send the email to reset her password to user.
   * @param User $user
   */
  private function send_reset_password_email_to($user) {
    $message = $this->render_as_string(
      'mails/reset_password',
      ['user' => $user]
    );

    $this->mailer->send([
      'from' => 'reset@gamespot.com',
      'from_name' => 'Gamespot reset password',
      'to' => $user->email,
      'subject' => 'Reset your password',
      'body' => $message,
      'is_html' => true
    ]);
  }

  /**
   * Reload the current_user and update the session.
   */
  private function reload_current_user() {
    $this->current_user->reload();
    Session::store_user($this->current_user);
  }

  /**
   * If there's no users with the given email or the password is wrong, render
   * the sign in form with errors.
   * @param User $user The user found by email.
   */
  private function detect_sign_in_errors($user) {
    $hashed_password = User::hash_password($this->params['password']);

    if (!$user || $hashed_password != $user->hashed_password) {
      Session::flash('error', 'Wrong email or password.');
      $this->render('users/sign_in');
    }

    $this->ensure_confirmed($user);
    $this->ensure_not_blocked($user);
  }

  /**
   * If the user is still unconfirmed, block her access (re-render the sign-in
   * form with errors).
   * @param User $user
   */
  private function ensure_confirmed($user) {
    if ($user->is_confirmed()) { return; }

    $msg = "You have to confirm the email address: {$user->email}.";
    Session::flash('error', $msg);
    $this->render('users/sign_in');
  }

  /**
   * If the user is blocked, block her access (re-render the sign-in form with
   * errors).
   * @param User $user
   */
  private function ensure_not_blocked($user) {
    if (!$user->is_blocked()) { return; }

    Session::flash('error', "{$user->email} is blocked. Contact the admin.");
    $this->render('users/sign_in');
  }

  /**
   * Send a confirmation email to $user containing a link with her confirmation
   * token.
   * @param User $user
   */
  private function send_confirmation_email_to($user) {
    $message = $this->render_as_string('mails/confirmation', [
      'user' => $user
    ]);

    $this->mailer->send([
      'from' => 'confirmation@gamespot.com',
      'from_name' => 'Gamespot confirmation',
      'to' => $user->email,
      'subject' => 'Confirmation email from Gamespot',
      'body' => $message,
      'is_html' => true
    ]);
  }
}
?>
