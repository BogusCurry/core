{adminheader}
<h3>
    <span class="fa fa-wrench"></span>
    {gt text='Main settings'}
</h3>

<form class="form-horizontal" role="form" action="{route name='zikulasettingsmodule_admin_updateconfig'}" method="post" enctype="application/x-www-form-urlencoded">
    <div>
        <input type="hidden" name="csrftoken" value="{insert name='csrftoken'}" />
        <fieldset>
            <legend>{gt text='Main info'}</legend>
            {if $modvars.ZConfig.multilingual}
                <div class="zikulasettings-tab-container">
                    <ul class="nav nav-tabs" role="tablist">
                    {foreach from=$languages key='code' item='language'}
                        <li role="presentation"{if $language eq $modvars.ZConfig.language_i18n|getlanguagename} class="active"{/if}><a href="#main-{$language|lower}" aria-controls="main-{$language|lower}" role="tab" data-toggle="tab">{$language}</a></li>
                    {/foreach}
                    </ul>
                    <div class="tab-content">
                    <!-- Tab panes -->
                    {foreach from=$languages key='code' item='language'}
                        <div role="tabpanel" class="tab-pane fade{if $language eq $modvars.ZConfig.language_i18n|getlanguagename} in active{/if}" id="main-{$language|lower}">
                            {assign var='varname' value='sitename_'|cat:$code}
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="settings_{$varname}">{gt text='Site name'}</label>
                                <div class="col-sm-9">
                                    <input id="settings_{$varname}" type="text" class="form-control" name="settings[{$varname}]" value="{$modvars.ZConfig.$varname|default:''|safetext}" size="50" maxlength="100" />
                                </div>
                            </div>
                            {assign var='varname' value='slogan_'|cat:$code}
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="settings_{$varname}">{gt text='Description line'}</label>
                                <div class="col-sm-9">
                                    <input id="settings_{$varname}" type="text" class="form-control" name="settings[{$varname}]" value="{$modvars.ZConfig.$varname|default:''|safetext}" size="50" maxlength="100" />
                                </div>
                            </div>
                        </div>
                    {/foreach}
                    </div>
                </div>
            {else}
                {assign var='varname' value='sitename_'|cat:$lang}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="settings_{$varname}">{gt text='Site name'}</label>
                    <div class="col-sm-9">
                        <input id="settings_{$varname}" type="text" class="form-control" name="settings[{$varname}]" value="{$modvars.ZConfig.$varname|default:''|safetext}" size="50" maxlength="100" />
                    </div>
                </div>
                {assign var='varname' value='slogan_'|cat:$lang}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="settings_{$varname}">{gt text='Description line'}</label>
                    <div class="col-sm-9">
                        <input id="settings_{$varname}" type="text" class="form-control" name="settings[{$varname}]" value="{$modvars.ZConfig.$varname|default:''|safetext}" size="50" maxlength="100" />
                    </div>
                </div>
            {/if}
            <div class="form-group">
                <label class="col-sm-3 control-label" for="settings_pagetitle">{gt text='Page title structure'}</label>
                <div class="col-sm-9">
                    <input id="settings_pagetitle" type="text" class="form-control" name="settings[pagetitle]" value="{$pagetitle|safetext}" size="50" maxlength="100" />
                    <em class="help-block">{gt text='Possible tags: %pagetitle%, %sitename%, %modulename%'}</em>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="settings_adminmail">{gt text="Admin's e-mail address"}</label>
                <div class="col-sm-9">
                    <input id="settings_adminmail" type="text" class="form-control" name="settings[adminmail]" value="{$modvars.ZConfig.adminmail|safetext}" size="30" maxlength="100" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{gt text='Disable site'}</label>
                <div class="col-sm-9">
                    <div id="settings_siteoff">
                        <input id="settings_siteoff_yes" type="radio" name="settings[siteoff]" value="1"{if $modvars.ZConfig.siteoff eq 1} checked="checked"{/if} />
                        <label for="settings_siteoff_yes">{gt text='Yes'}</label>
                        <input id="settings_siteoff_no" type="radio" name="settings[siteoff]" value="0"{if $modvars.ZConfig.siteoff eq 0} checked="checked"{/if} />
                        <label for="settings_siteoff_no">{gt text='No'}</label>
                    </div>
                </div>
            </div>
            <div id="settings_siteoff_container">
                <div class="form-group" data-switch="settings[siteoff]" data-switch-value="1">
                    <label class="col-sm-3 control-label" for="settings_siteoffreason">{gt text='Reason for disabling site'}</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="settings_siteoffreason" name="settings[siteoffreason]" cols="50" rows="5">{$modvars.ZConfig.siteoffreason|safetext}</textarea>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>{gt text='Meta tag settings'}</legend>
            {if $modvars.ZConfig.multilingual}
                <div class="zikulasettings-tab-container">
                    <ul class="nav nav-tabs" role="tablist">
                        {foreach from=$languages key='code' item='language'}
                            <li role="presentation"{if $language eq $modvars.ZConfig.language_i18n|getlanguagename} class="active"{/if}><a href="#meta-{$language|lower}" aria-controls="meta-{$language|lower}" role="tab" data-toggle="tab">{$language}</a></li>
                        {/foreach}
                    </ul>
                    <div class="tab-content">
                        <!-- Tab panes -->
                        {foreach from=$languages key='code' item='language'}
                            <div role="tabpanel" class="tab-pane fade{if $language eq $modvars.ZConfig.language_i18n|getlanguagename} in active{/if}" id="meta-{$language|lower}">
                                {assign var='varname' value='defaultpagetitle_'|cat:$code}
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="settings_{$varname}">{gt text='Default page title'}</label>
                                    <div class="col-sm-9">
                                        <input id="settings_{$varname}" type="text" class="form-control" name="settings[{$varname}]" value="{$modvars.ZConfig.$varname|default:''|safetext}" size="50" maxlength="255" />
                                    </div>
                                </div>
                                {assign var='varname' value='defaultmetadescription_'|cat:$code}
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="settings_{$varname}">{gt text='Default meta description'}</label>
                                    <div class="col-sm-9">
                                        <input id="settings_{$varname}" type="text" class="form-control" name="settings[{$varname}]" value="{$modvars.ZConfig.$varname|default:''|safetext}" size="50" maxlength="255" />
                                    </div>
                                </div>
                                {assign var='varname' value='metakeywords_'|cat:$code}
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="settings_{$varname}">{gt text='Default meta keywords'}</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="settings_{$varname}" name="settings[{$varname}]" cols="60" rows="3">{$modvars.ZConfig.$varname|default:''|safetext}</textarea>
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            {else}
                {assign var='varname' value='defaultpagetitle_'|cat:$lang}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="settings_{$varname}">{gt text='Default page title'}</label>
                    <div class="col-sm-9">
                        <input id="settings_{$varname}" type="text" class="form-control" name="settings[{$varname}]" value="{$modvars.ZConfig.$varname|default:''|safetext}" size="50" maxlength="255" />
                    </div>
                </div>
                {assign var='varname' value='defaultmetadescription_'|cat:$lang}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="settings_{$varname}">{gt text='Default meta description'}</label>
                    <div class="col-sm-9">
                        <input id="settings_{$varname}" type="text" class="form-control" name="settings[{$varname}]" value="{$modvars.ZConfig.$varname|default:''|safetext}" size="50" maxlength="255" />
                    </div>
                </div>
                {assign var='varname' value='metakeywords_'|cat:$lang}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="settings_{$varname}">{gt text='Default meta keywords'}</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="settings_{$varname}" name="settings[{$varname}]" cols="60" rows="3">{$modvars.ZConfig.$varname|default:''|safetext}</textarea>
                    </div>
                </div>
            {/if}
        </fieldset>
        <fieldset>
            <legend>{gt text='Start page settings'}</legend>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="settings_startController">{gt text='Start Controller'}</label>
                <div class="col-sm-9">
                    <input id="settings_startController" type="text" class="form-control" name="settings[startController]" value="{$modvars.ZConfig.startController|default:''|safetext}" size="10" maxlength="300" />
                    <em class="help-block">{gt text="MyModuleName:Controller:method"}</em>
                    <em class="help-block alert alert-warning">{gt text="Start Controller will take precedence over module/type/function settings below."}<br />
                        {gt text="This setting only works with Core-1.4.x/2.0 compatible modules (with routes)."}<br />
                        {gt text="The module/type/func method of setting the start page is deprecated and will be removed at Core-2.0."}<br />
                        {gt text="Start function arguments (below) can also be combined with this setting."}</em>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="settings_startpage">{gt text='Start module'}</label>
                <div class="col-sm-9">
                    <select class="form-control" id="settings_startpage" name="settings[startpage]">
                        <option value="">{gt text='No start module (static frontpage)'}</option>
                        {html_select_modules selected=$modvars.ZConfig.startpage type='user'}
                    </select>
                    <em class="help-block">{gt text="('index.php' points to this)"}</em>
                </div>
            </div>    
            <div id="settings_startpage_container" style="overflow: hidden">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="settings_starttype">{gt text='Start function type (required)'}</label>
                    <div class="col-sm-9">
                        <input id="settings_starttype" type="text" class="form-control" name="settings[starttype]" value="{$modvars.ZConfig.starttype|safetext}" size="10" maxlength="300" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="settings_startfunc">{gt text='Start function (required)'}</label>
                    <div class="col-sm-9">
                        <input id="settings_startfunc" type="text" class="form-control" name="settings[startfunc]" value="{$modvars.ZConfig.startfunc|safetext}" size="20" maxlength="300" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="settings_startargs">{gt text='Start function arguments'}</label>
                    <div class="col-sm-9">
                        <input id="settings_startargs" type="text" class="form-control" name="settings[startargs]" value="{$modvars.ZConfig.startargs|safetext}" size="20" maxlength="300" />
                        <em class="help-block">({gt text='Separate with & for example:' } <code>foo=2&bar=5</code>)</em>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>{gt text='Front Controller settings'}</legend>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="settings_entrypoint">{gt text='Site entry point (front controller)'}</label>
                <div class="col-sm-9">
                    <input id="settings_entrypoint" type="text" class="form-control" name="settings[entrypoint]" value="{$modvars.ZConfig.entrypoint|safetext}" size="20" maxlength="60" />
                    <em class="help-block">{gt text='(Default: index.php)'}</em>
                    <p class="help-block alert alert-info">{gt text="Notice: The entry point file must be present in the Zikula root directory before you set it here as your site's start page."}</p>
                    <p class="help-block alert alert-danger">{gt text="Warning: This feature is deprecated and it is not recommended to change from index.php."}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{gt text='Strip entry point (front controller) from URLs'}</label>
                <div id="settings_shorturlsstripentrypoint" class="col-sm-9">
                    <input id="shorturlsstripentrypoint1" type="radio" name="settings[shorturlsstripentrypoint]" value="1"{if $modvars.ZConfig.shorturlsstripentrypoint eq 1} checked="checked"{/if} />
                    <label for="shorturlsstripentrypoint1">{gt text='Yes (recommended)'}</label>
                    <input id="shorturlsstripentrypoint0" type="radio" name="settings[shorturlsstripentrypoint]" value="0"{if $modvars.ZConfig.shorturlsstripentrypoint eq 0} checked="checked"{/if} />
                    <label for="shorturlsstripentrypoint0">{gt text='No'}</label>
                    <em class="help-block alert alert-warning">{gt text="This setting was part of the 'shorturl configuration in the past (below)."}<br />
                        {gt text="It is now moved here because it is also used with core-1.4.x routing. This feature is deprecated."}</em>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>{gt text='General settings'}</legend>
            <div class="form-group">
                <label class="col-sm-3 control-label">{gt text='Activate compression'}</label>
                <div class="col-sm-9">
                    <div id="settings_usecompression">
                        <input id="UseCompression1" type="radio" name="settings[UseCompression]" value="1"{if $modvars.ZConfig.UseCompression eq 1} checked="checked"{/if} />
                        <label for="UseCompression1">{gt text='Yes'}</label>
                        <input id="UseCompression0" type="radio" name="settings[UseCompression]" value="0"{if $modvars.ZConfig.UseCompression eq 0} checked="checked"{/if} />
                        <label for="UseCompression0">{gt text='No'}</label>
                    </div>
                    {if isset($zlibEnabled) && !$zlibEnabled}
                        <p class="alert alert-warning">{gt text='Notice: The PHP Zlib extension is not enabled on your host. This setting will not do anything in this case.'}</p>
                    {/if}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="settings_profilemodule">{gt text='Module used for managing user profiles'}</label>
                <div class="col-sm-9">
                    <select class="form-control" id="settings_profilemodule" name="settings[profilemodule]">
                        <option value="">{gt text='No user profiles'}</option>
                        {html_select_modules selected=$modvars.ZConfig.profilemodule type='profile'}
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="settings_messagemodule">{gt text='Module used for private messaging'}</label>
                <div class="col-sm-9">
                    <select class="form-control" id="settings_messagemodule" name="settings[messagemodule]">
                        <option value="">{gt text='No private messaging'}</option>
                        {html_select_modules selected=$modvars.ZConfig.messagemodule type='message'}
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="settings_ajaxtimeout">{gt text='Time-out for Ajax connections'}</label>
                <div class="col-sm-9">
                    <input class="form-control" id="settings_ajaxtimeout" name="settings[ajaxtimeout]" value="{$modvars.ZConfig.ajaxtimeout}" />
                    <em>{gt text='(in milliseconds, default 5000 = 5 seconds)'}</em>
                    <p class="help-block alert alert-info">{gt text='Notice: Increase this value if mobile appliances experience problems with using the site.'}</p>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>{gt text='Permalinks settings'}</legend>
            <p class="alert alert-warning">{gt text="Notice: The following settings will rewrite your permalinks. Sometimes, international characters like 'ñ' and 'ß' may be re-encoded by your browser. Although this is technically the correct action, it may not be aesthetically pleasing.  These settings allow you to replace those characters, using a pair of comma-separated lists. The two fields below should resemble the examples provided: The first element of 'List to search for' will replace the first element in the 'List to replace with' and so on. In the example below, 'À' would be replace with 'A', and 'Á' with 'A'. If you do not want to use this feature, leave both fields blank."}</p>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="settings_permasearch">{gt text='List to search for'} </label>
                <div class="col-sm-9">
                    <input id="settings_permasearch" class="form-control" type="text" name="settings[permasearch]" value="{$modvars.ZConfig.permasearch}" size="60" /><br />
                    <label for="settings_permasearch_default">{gt text='Default'}</label>
                    <input id="settings_permasearch_default" type="text" class="form-control" readonly="readonly" value="{gt text='À,Á,Â,Ã,Å,à,á,â,ã,å,Ò,Ó,Ô,Õ,Ø,ò,ó,ô,õ,ø,È,É,Ê,Ë,è,é,ê,ë,Ç,ç,Ì,Í,Î,Ï,ì,í,î,ï,Ù,Ú,Û,ù,ú,û,ÿ,Ñ,ñ,ß,ä,Ä,ö,Ö,ü,Ü'}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="settings_permareplace">{gt text='List to replace with'}</label>
                <div class="col-sm-9">
                    <input id="settings_permareplace" class="form-control" type="text" name="settings[permareplace]" value="{$modvars.ZConfig.permareplace}" size="60" /><br />
                    <label for="settings_permareplace_default">{gt text='Default'}</label>
                    <input id="settings_permareplace_default" type="text" class="form-control" readonly="readonly" value="{gt text='A,A,A,A,A,a,a,a,a,a,O,O,O,O,O,o,o,o,o,o,E,E,E,E,e,e,e,e,C,c,I,I,I,I,i,i,i,i,U,U,U,u,u,u,y,N,n,ss,ae,Ae,oe,Oe,ue,Ue'}" />
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>{gt text='Short URL settings'}</legend>
            <p class="alert alert-warning">{gt text="Notice: This feature is deprecated in favor of Symfony routing. This site may have a mixture of modules of both types; those capable of using the old functionality, and those using routing."}</p>
            <input type="hidden" id="settings_shorturlstype_directory" name="settings[shorturlstype]" value="0" />
            <div class="form-group">
                <label class="col-sm-3 control-label">{gt text='Enable directory-based short URLs'}</label>
                <div class="col-sm-9">
                    <input id="settings_shorturls_yes" type="radio" name="settings[shorturls]" value="1"{if $modvars.ZConfig.shorturls eq 1} checked="checked"{/if} />
                    <label for="settings_shorturls_yes">{gt text='Yes'}</label>
                    <input id="settings_shorturls_no" type="radio" name="settings[shorturls]" value="0"{if $modvars.ZConfig.shorturls eq 0} checked="checked"{/if} />
                    <label for="settings_shorturls_no">{gt text='No'}</label>
                </div>
            </div>
            <div data-switch="settings[shorturls]" data-switch-value="1">
                <div id="settings_shorturlsseparator_container" class="form-group">
                    <label class="col-sm-3 control-label" for="settings_shorturlsseparator">{gt text='Separator for permalink titles'}</label>
                    <div class="col-sm-9">
                        <input id="settings_shorturlsseparator" class="form-control" type="text" size="1" maxlength="1" name="settings[shorturlsseparator]" value="{$modvars.ZConfig.shorturlsseparator}" />
                    </div>
                </div>
                <div id="settings_shorturls_defaultmodule_container" class="form-group">
                    <label class="col-sm-3 control-label" for="settings_shorturls_defaultmodule">{gt text='Do not display module name in short URLs for'}</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="settings_shorturls_defaultmodule" name="settings[shorturlsdefaultmodule]">
                            <option value="">{gt text='(disabled)'}</option>
                            {html_options options=$modulesList selected=$modvars.ZConfig.shorturlsdefaultmodule|default:null}
                        </select>
                        <p class="help-block alert alert-info">{gt text='Routed modules cannot utilize this feature. Edit the routes directly instead.'}</p>
                    </div>
                </div>
            </div>
        </fieldset>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button class="btn btn-success" title="{gt text='Save'}">{gt text='Save'}</button>
                <a class="btn btn-danger" href="{route name='zikulasettingsmodule_admin_index'}" title="{gt text='Cancel'}">{gt text='Cancel'}</a>
            </div>
        </div>
    </div>
</form>
{adminfooter}
