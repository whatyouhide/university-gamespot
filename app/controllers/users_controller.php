<?php
class UsersController extends Controller {
  // GET /users/sign_in
  // POST /users/sign_in
  // This action will be redirected to the appropriate private method based on
  // the type of the current request being POST or GET.
  public function sign_in() {
    if ($this->request->is_post()) {
      $this->sign_in_post();
    } else if ($this->request->is_get()) {
      $this->sign_in_get();
    }
  }

  // POST /users/sign_out
  // Remove the 'user' field from the session and redirect to the home page.
  public function sign_out() {
    unset($_SESSION['user']);
    redirect('/', ['notice' => 'Signed out successfully.']);
  }

  // GET /users/sign_up
  // POST /users/sign_up
  // Display the sign up form if the request type is GET, otherwise sign up a
  // new user (if the request type is POST).
  public function sign_up() {
    if ($this->request->is_post()) {
      $this->sign_up_post();
    } else if ($this->request->is_get()) {
      $this->sign_up_get();
    }
  }

  // GET /users/profile
  // Displays the user profile if a user is logged in, otherwise it redirects to
  // the home page.
  public function profile() {
    if (is_signed_in()) {
      $this->render('users/profile');
    } else {
      redirect('/', ['error' => 'You need to be logged in.']);
    }
  }

  // Private methods

  // Display the sign in form.
  private function sign_in_get() {
    $this->render('users/sign_in', array('sign_in_error' => false));
  }

  // Actually sign in the user.
  private function sign_in_post() {
    $user = User::find($this->params['email']);

    // No user with the given email: render the sign-in form with an error.
    if (!$user) {
      $this->render('users/sign_in', ['sign_in_error' => true]);
    }

    // Check if the password is correct: if it is, store the user's infos in the
    // Session and redirect to the homepage; if it isn't, re-render this
    // template with error infos.
    if (User::hash_password($_POST['password']) == $user['hashed_password']) {
      Session::user($user);
      redirect('/');
    } else {
      $this->render('users/sign_in', ['sign_in_error' => true]);
    }
  }

  // Display the sign up form.
  private function sign_up_get() {
    $this->render('users/sign_up');
  }

  // Sign up the user and redirect to /users/signed_up.
  private function sign_up_post() {
    User::create(array(
      'email' => $this->params['email'],
      'password' => $this->params['password'],
      'first_name' => $this->params['first_name'],
      'last_name' => $this->params['last_name']
    ));

    // Render the confirmation page (successfully signed up).
    $this->render('users/signed_up');
  }
}
?>
