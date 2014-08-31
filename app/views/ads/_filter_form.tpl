<form action="{url to='/ads/filter'}" method="GET">
  <div class="fields-row">
    <label for="console">Filter by console:</label>
    {html_options
      name=console
      options=$consoles_for_select
      selected=$starting_values.console
    }

    <label for="city">Filter by city:</label>
    {html_options
      name=city
      options=$cities_for_select
      selected=$starting_values.city
    }

    <label>
      {if $starting_values['last-7-days'] eq 'true'}
        {$checked=checked}
      {else}
        {$checked=''}
      {/if}
      <input type="checkbox" name="last-7-days" {$checked} value="true">
      Last 7 days
    </label>
  </div>

  <div class="type">
    <div>Ad type</div>

    <div class="fields-row">
      <label>
        <input
          type="radio"
          name="type"
          value="game"
          {if $starting_values.type eq 'game'}checked{/if}>
        Game
      </label>
      {html_options
        name=game
        options=$games_for_select
        selected=$starting_values.game
      }
    </div>

    <div class="fields-row">
      <label>
        <input
          type="radio"
          name="type"
          value="accessory"
          {if $starting_values.type eq 'accessory'}checked{/if}>
        Accessory
      </label>
      {html_options
        name=accessory
        options=$accessories_for_select
        selected=$starting_values.accessory
      }
    </div>
  </div>

  <div class="fields-row slider-container">
    <label for="max-price">Maximum price (0 means no price filter)</label>

    <div
      class="range-slider"
      data-slider="{$starting_values['max-price']}"
      data-options="display_selector: #slider-output; start: 0; end: 200;">
      <span class="range-slider-handle" role="slider" tabindex="0"></span>
      <span class="range-slider-active-segment"></span>
      <input name="max-price" type="hidden">
    </div>

    <div><span id="slider-output"></span></div>
  </div>

  <input type="submit" value="Filter">

  <a href="{url to='/ads'}">Clear all filters</a>
</form>
