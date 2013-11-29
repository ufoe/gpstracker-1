<!DOCTYPE html>
<html>
    <head>            
        {include file='javascript_css.tpl' min=''}
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">            
        <title>{block name=title}Titolo da sistemare{/block}</title>
    </head>
<body>
<div id="content" style="margin:10px;">
{block name=body}{/block}
</div>

</body>
</html>
{if (isset($debug))}{debug}{/if}
