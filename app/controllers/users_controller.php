<?php
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
   * Display a user's profile if she's logged in, or redirect to the home page.
   */
  public function profile() {
    if (Session::user()) {
      $this->render('users/profile');
    } else {
      redirect('/', ['error' => 'You need to be logged in.']);
    }
  }

  /**
   * Display the sign in form.
   */
  private function sign_in_get() {
    $this->render('users/sign_in', array('sign_in_error' => false));
  }

  /**
   * Sign in the user if sign in infos are correct, otherwise re-render the sign
   * in form with errors displayed.
   */
  private function sign_in_post() {
    $user = User::find($this->params['email']);

    // No user with the given email: render the sign-in form with an error.
    if (!$user) {
      $this->render('users/sign_in', ['sign_in_error' => true]);
    }

    // Check if the password is correct: if it is, store the user's infos in the
    // Session and redirect to the homepage; if it isn't, re-render this
    // template with error infos.
    $hashed_password = User::hash_password($this->params['password']);
    if ($hashed_password == $user->hashed_password) {
      Session::store_user($user);
      redirect('/', ['notice' => 'Successfully logged in.']);
    } else {
      $this->render('users/sign_in', ['sign_in_error' => true]);
    }
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
    User::create(array(
      'email' => $this->params['email'],
      'password' => $this->params['password'],
      'first_name' => $this->params['first_name'],
      'last_name' => $this->params['last_name']
    ));

    $this->render('users/signed_up');
  }
}
?>
