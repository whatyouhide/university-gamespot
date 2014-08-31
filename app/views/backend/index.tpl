{extends 'backend.tpl'}

{block name=content}
There are {$signed_in_users_count} signed in users.
There are {$regular_users_count} users of the website.
There are {$staff_members_count} staff members.

There are {$ads_count} ads.

There have been {$number_of_visits} visits on the website.

There have been {$unique_visitors_count} unique visitors.
{/block}
