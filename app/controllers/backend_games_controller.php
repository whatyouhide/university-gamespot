<?php
class BackendGamesController extends AdminController {
  /**
   * GET /games
   * List all the games.
   */
  public function index() {
    $this->restrict_to_permission('manage_products');

    $this->games = Game::all();
    $this->render('games/index');
  }

  /**
   * GET /games/new
   * Render the form for a new console.
   */
  public function nuevo() {
    $this->restrict_to_permission('manage_products');

    $this->console = Game::find($this->params['id']);
    $this->render('games/nuevo');
  }

  /**
   * GET /games/edit?id=1
   * Edit a console.
   */
  public function edit() {
    $this->restrict_to_permission('manage_products');

    $this->game = Game::find($this->params['id']);
    $this->render('games/edit');
  }

  /**
   * POST /games/create
   * Create a new console.
   */
  public function create() {
    $this->restrict_to_permission('manage_products');

    $new_game = Game::create($this->game_params());
    $this->update_game_cover_image($new_game);

    redirect('/backend/games', ['notice' => 'Successfully created.']);
  }

  /**
   * POST /games/update?id=1
   * Update an existing console.
   */
  public function update() {
    $this->restrict_to_permission('manage_products');

    $game = Game::find($this->params['id']);
    $game->update($this->game_params());
    $this->update_game_cover_image($game);

    redirect('/backend/games', ['notice' => 'Successfully updated.']);
  }

  /**
   * GET /games/destroy?id=1
   * Destroy a console.
   */
  public function destroy() {
    $this->restrict_to_permission('manage_products');

    $console = Game::find($this->params['id']);
    $console->destroy();
    redirect('/backend/games', ['notice' => 'Successfully destroyed.']);
  }

  /**
   * Return the parameters needed for updating a console.
   */
  private function game_params() {
    return [
      'name' => $this->params['name'],
      'release_date' => date('Y-m-d', strtotime($this->params['release_date'])),
      'description' => $this->params['description'],
      'software_house' => $this->params['software_house']
    ];
  }

  /**
   * Update the cover image of a given game.
   * @param Game $game
   */
  private function update_game_cover_image($game) {
    $cover_image = Uploader::get('cover_image');

    if ($cover_image) {
      $upload = Upload::create_from_uploaded_file($cover_image);
      $game->update_cover_image($upload);
    } else {
      $game->update_cover_image(null);
    }
  }
}
?>