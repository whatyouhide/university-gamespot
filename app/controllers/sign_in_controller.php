<?php
class SignInController extends Controller {
  // GET /sign_in
  // Render the sign in form.
  public function index() {
    $this->render('sign_in/index', array(
      'sign_in_error' => false
    ));
  }

  // POST /sign_in/post
  // This action is called by a form. If the URL is manually entered by the
  // user, this action will redirect to /sign_in/index.
  public function post() {
    // If the request is a GET (probably a manually inserted URL), redirect to
    // the index action.
    if (!is_post_request()) {
      redirect('/sign_in');
    }

    // Issue a query for user matching the email in the POST request.
    $query_results = User::where_attribute_is('email', $_POST['email']);

    // Set a $user variable, which is null if the query results are empty,
    // otherwise it's the first (and only given db constraints) user.
    $user = empty($query_results) ? null : $query_results[0];

    // No user with the given email: render the sign-in form with an error.
    if (!$user) {
      $this->render('sign_in/index', array(
        'sign_in_error' => true
      ));
      return;
    }

    // Check if the password is correct: if it is, store the user's infos in the
    // $_SESSION array and redirect to the homepage; if it isn't, re-render this
    // template with error infos.
    if (md5($_POST['password']) == $user['hashed_password']) {
      $_SESSION['user'] = $user;
      redirect('/');
    } else {
      $this->render('sign_in/index', array(
        'sign_in_error' => true
      ));
      return;
    }
  }
}
?>
