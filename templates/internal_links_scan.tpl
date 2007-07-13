[
{foreach from=$sitemap item=s}
{literal}{title:"{/literal}{$s.title}",children:[{$s.htmlTree}]{literal}}{/literal}{if not $last},{/if}
{/foreach}
]