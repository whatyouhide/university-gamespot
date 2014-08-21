{extends 'frontend.tpl'}

{block name=content}

<section class="all-games">

  {foreach from=$all_games key=games_column item=games}
    <section class="{$games_column}-games game-column">

      {foreach from=$games item=game}
        <article class="single-game">
          <h1>{$game->name}</h1>
          {image_path image=$game->cover_image}
          <section class="description">{$game->description}</section>
        </article>
      {/foreach}

    </section>
  {/foreach}

</section>

{/block}
