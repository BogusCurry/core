<div class="menutree_vertical_left_container">
    {menutree data=$menutree_content id='menu'|cat:$blockinfo.bid class='menutree_vertical_left' ext=true}
    {if $menutree_editlinks}
    <p class="menutree_vertical_left_controls">
        <a href="{route name='zikulablocksmodule_block_edit' blockEntity=$blockinfo.bid addurl=1}#menutree_tabs" title="{gt text='Add the current URL as new link in this block'}">{gt text='Add current URL'}</a><br />
        <a href="{route name='zikulablocksmodule_block_edit' blockEntity=$blockinfo.bid fromblock=1}" title="{gt text='Edit this block'}">{gt text='Edit this block'}</a>
    </p>
    {/if}
</div>
