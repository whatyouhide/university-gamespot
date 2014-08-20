<?php
/**
 * @package Gamespot
 * @subpackage Controllers
 */
class UsersController extends Controller {
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

    $this->render('users/profile');
  }

  /**
   * GET /users/settings
   * The settings for a specific user.
   */
  public function settings() {
    $this->render('users/settings');
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

    if ($old_hashed != $this->current_user->hashed_password) {
      $flash = ['error' => 'Wrong password.'];
    } else if (empty($new_pass)) {
      $flash = ['error' => "New password can't be empty."];
    } else if ($old_hashed == User::hash_password($new_pass)) {
      $flash = ['error' => "Password must change."];
    } else {
      $this->current_user->update_password($new_pass);
      $this->reload_current_user();
      $flash = ['notice' => 'Password updated successfully.'];
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
    $this->render('users/settings', ['notice' => 'Deleted successfully']);
  }

  /**
   * Display the sign in form.
   */
  private function sign_in_get() {
    $this->render('users/sign_in', ['sign_in_error' => false]);
  }

  /**
   * Sign in the user if sign in infos are correct, otherwise re-render the sign
   * in form with errors displayed.
   */
  private function sign_in_post() {
    $user = User::find_by_attribute('email', $this->params['email']);

    // No user with the given email: render the sign-in form with an error.
    if (!$user) {
      $this->render('users/sign_in', ['sign_in_error' => true]);
    }

    // Check if the password is correct: if it is, store the user's infos in the
    // Session and redirect to the homepage; if it isn't, re-render this
    // template with error infos.
    $hashed_password = User::hash_password($this->params['password']);
    if ($hashed_password != $user->hashed_password) {
      $this->render('users/sign_in', ['sign_in_error' => true]);
    }

    Session::store_user($user);

    $new_url = Session::referer_and_reset_or_url('/');
    redirect($new_url, ['notice' => 'Successfully logged in.']);
  }

  /**
   * Display the sign up form.
   */
  private function sign_up_get() {
    $this->render('users/sign_up');
  }

  /**
   * Sign up a user and redirect to the welcome page.
   */
  private function sign_up_post() {
    User::create([
      'email' => $this->params['email'],
      'password' => $this->params['password'],
      'first_name' => $this->params['first_name'],
      'last_name' => $this->params['last_name']
    ]);

    $this->render('users/signed_up');
  }

  /**
   * Reload the current_user and update the session.
   */
  private function reload_current_user() {
    $this->current_user->reload();
    Session::store_user($this->current_user);
  }
}
?>
