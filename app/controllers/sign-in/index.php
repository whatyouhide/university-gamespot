<?php
class SignInController {
  function __construct() {
    $this->smarty = new GamespotSmarty();
    $this->db = new DB();
    $this->email_not_found = false;
    $this->wrong_password = false;
  }

  public function init() {
    // If the user has just visited this page (a GET request), render it and
    // exit.
    if (empty($_POST)) {
      $this->render();
      return;
    }

    $matching_users = User::where_attribute_is('email', $_POST['email']);

    // Wrong email: if there's no user with the given email, render (with
    // errors) and exit.
    if (empty($matching_users)) {
      $this->email_not_found = true;
      $this->render();
      return;
    }

    $password = $_POST['password'];
    $user = $matching_users[0];

    // Check if the password is correct: if it is, store the user's infos in the
    // $_SESSION array and redirect to the homepage; if it isn't, re-render this
    // template with error infos.
    if (md5($password) == $user['hashed_password']) {
      $_SESSION['user'] = $user;
      redirect('/');
    } else {
      $this->wrong_password = true;
      $this->render();
    }
  }

  // Render the Smarty template.
  private function render() {
    $this->smarty->assign( 'email_not_found', $this->email_not_found );
    $this->smarty->assign( 'wrong_password', $this->wrong_password );

    $this->smarty->display( 'sign-in/index.tpl' );
  }
}

// Start up the controller.
$controller = new SignInController();
$controller->init();
?>
