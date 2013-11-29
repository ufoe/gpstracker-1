{$name=$name|default:'nome'}
{$indice=$indice|default:$name}
{$label=$label|default:$name}
{$editable=$editable|default:"true"}
{query query=$query assign="elenco"}{
    name: '{$name}', index: '{$name}', label: '{$label}', width: '{$width|default:150}', sorttype: "text", align: "left",editable: {$editable},formatter:'select'
    ,edittype: "select" ,editoptions: { value: "{foreach from=$elenco item=scelta name=foo}{$scelta.id}:{$scelta.label}{if ! $smarty.foreach.foo.last};{/if}{/foreach}" }
    ,stype: "select", searchoptions: { sopt: ["eq", "ne"],value: ":;{foreach from=$elenco item=scelta name=foo}{$scelta.id}:{$scelta.label}{if ! $smarty.foreach.foo.last};{/if}{/foreach}" }
}
