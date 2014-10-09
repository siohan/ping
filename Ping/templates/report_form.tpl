{if $messagesortie!=''}<h2>{$messagesortie}</h2>{/if}
       {$form_start}
       <p>{$input_name}</p>
       <p>{$input_type}</p>
       <p>{$input_lights}{$label_lights}</p>
<p>Le champ caché {$envoi}</p>
       <p>{$title_description}<br />{$input_description}</p>
       <p>{$submit}</p>
{$form_end}