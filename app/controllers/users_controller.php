<?php
class UsersController extends Controller {
  // GET /users/sign_in
  // POST /users/sign_in
  // This action will be redirected to the appropriate private method based on
  // the type of the current request being POST or GET.
  // Render the sign in form.
  public function sign_in() {
    if (is_post_request()) {
      $this->sign_in_post();
    } else if (is_get_request()) {
      $this->sign_in_get();
    }
  }

  // POST /users/sign_out
  // Remove the 'user' field from the session and redirect to the home page.
  public function sign_out() {
    unset($_SESSION['user']);
    redirect('/');
  }

  // GET /users/sign_up
  // POST /users/sign_up
  // Display the sign up form if the request type is GET, otherwise sign up a
  // new user (if the request type is POST).
  public function sign_up() {
    if (is_post_request()) {
      $this->sign_up_post();
    } else if (is_get_request()) {
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
      redirect('/');
    }
  }



  // Private methods

  // Display the sign in form.
  private function sign_in_get() {
    $this->render('users/sign_in', array(
      'sign_in_error' => false
    ));
  }

  // Actually sign in the user.
  private function sign_in_post() {
    // Issue a query for user matching the email in the POST request.
    $query_results = User::where_attribute_is('email', $_POST['email']);

    // Set a $user variable, which is null if the query results are empty,
    // otherwise it's the first (and only given db constraints) user.
    $user = empty($query_results) ? null : $query_results[0];

    // No user with the given email: render the sign-in form with an error.
    if (!$user) {
      $this->render('users/sign_in', array(
        'sign_in_error' => true
      ));
    }

    // Check if the password is correct: if it is, store the user's infos in the
    // $_SESSION array and redirect to the homepage; if it isn't, re-render this
    // template with error infos.
    if (md5($_POST['password']) == $user['hashed_password']) {
      $_SESSION['user'] = $user;
      redirect('/');
    } else {
      $this->render('users/sign_in', array(
        'sign_in_error' => true
      ));
    }

  }

  // Display the sign up form.
  private function sign_up_get() {
    $this->render('users/sign_up');
  }

  // Sign up the user and redirect to /users/signed_up.
  private function sign_up_post() {
    User::create(array(
      'email' => $_POST['email'],
      'hashed_password' => md5($_POST['password']),
      'first_name' => $_POST['first_name'],
      'last_name' => $_POST['last_name']
    ));

    // Render the confirmation page (successfully signed up).
    $this->render('users/signed_up');
  }

}
?>
