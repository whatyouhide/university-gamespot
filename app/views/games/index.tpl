{extends 'skeleton.tpl'}

{block name=container}

<section class="all-games">

  {foreach from=$all_games key=games_column item=games}
    <section class="{$games_column}-games game-column">

      {foreach from=$games item=game}
        <div class="single-game">
          <h2>{$game.name}</h2>
          <img src="{$uploads}/{$game.cover_image}">
          <section class="game-description">
            {$game.description|truncate:200:"..."}
          </section>
        </div>
      {/foreach}

    </section>
  {/foreach}

</section>

{/block}
