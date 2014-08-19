<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="{$lib}/javascripts/dropzone.js"></script>

<script src="{$javascripts}/dropzone.js"></script>
<script src="{$javascripts}/data-confirm.js"></script>

{if file_exists('{$root}/app/assets/javascripts/pages/{$controller_name}.js')}
  <script src="{$javascripts}/pages/{$controller_name}.js"></script>
{/if}
