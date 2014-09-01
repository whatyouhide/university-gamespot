{extends 'backend.tpl'}

{block name=content}
  <section class="stats">
    <h1>Stats</h1>

    <div class="signed-in-users">
      <p class="there-are">There are</p>
      <p class="number">{$signed_in_users_count}</p>
      <p class="what">signed in users</p>
    </div>

    <div class="regular-users">
      <p class="there-are">There are</p>
      <p class="number">{$regular_users_count}</p>
      <p class="what">users of the website</p>
    </div>

    <div class="staff-members">
      <p class="there-are">There are</p>
      <p class="number">{$staff_members_count}</p>
      <p class="what">staff members</p>
    </div>

    <div class="ads">
      <p class="there-are">There are</p>
      <p class="number">{$ads_count}</p>
      <p class="what">ads</p>
    </div>

    <div class="visits">
      <p class="there-are">There have been</p>
      <p class="number">{$number_of_visits}</p>
      <p class="what">visits on the website</p>
    </div>

    <div class="unique-visitors">
      <p class="there-are">There have been</p>
      <p class="number">{$unique_visitors_count}</p>
      <p class="what">unique visitors</p>
    </div>
  </section>
{/block}
