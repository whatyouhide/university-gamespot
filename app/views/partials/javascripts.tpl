<!-- CDNs -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- Libs -->
<script src="{$lib}/javascripts/lodash.min.js"></script>
<script src="{$lib}/javascripts/froala_editor.min.js"></script>
<script src="{$lib}/javascripts/dropzone.js"></script>
<script src="{$lib}/javascripts/chosen.jquery.min.js"></script>
<script src="{$lib}/javascripts/selectize.min.js"></script>
<script src="{$lib}/javascripts/moment.min.js"></script>
<script src="{$lib}/javascripts/foundation.min.js"></script>

<!-- Custom scripts -->
<script src="{$javascripts}/config.js"></script>
<script src="{$javascripts}/functions.js"></script>
<script src="{$javascripts}/dropzone.js"></script>
<script src="{$javascripts}/data-hoverable.js"></script>
<script src="{$javascripts}/data-confirm.js"></script>
<script src="{$javascripts}/data-ago.js"></script>
<script src="{$javascripts}/data-chosen.js"></script>
<script src="{$javascripts}/flashes.js"></script>
<script src="{$javascripts}/froala.js"></script>
<script src="{$javascripts}/style-tweaks.js"></script>

<script>$(document).foundation();</script>

<!-- Page-specific JS -->
{if file_exists("{$root}/app/assets/javascripts/pages/{$controller_name}.js")}
  <script src="{$javascripts}/pages/{$controller_name}.js"></script>
{/if}
