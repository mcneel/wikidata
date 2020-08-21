<?php
/**
 * Default settings for the oauth plugin
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 */

$conf['auth0-key']           = '';
$conf['auth0-secret']        = '';
$conf['auth0-domain']        = '';
$conf['custom-redirectURI']  = '';
$conf['facebook-key']        = '';
$conf['facebook-secret']     = '';
$conf['github-key']          = '';
$conf['github-secret']       = '';
$conf['google-key']          = '';
$conf['google-secret']       = '';
$conf['dataporten-key']      = '';
$conf['dataporten-secret']   = '';
$conf['keycloak-key']        = '';
$conf['keycloak-secret']     = '';
$conf['keycloak-authurl']    = 'https://keycloak.example.com/auth/realms/{realm}/protocol/openid-connect/auth';
$conf['keycloak-tokenurl']   = 'https://keycloak.example.com/auth/realms/{realm}/protocol/openid-connect/token';
$conf['keycloak-userinfourl'] = 'https://keycloak.example.com/auth/realms/{realm}/protocol/openid-connect/userinfo';
$conf['yahoo-key']           = '';
$conf['yahoo-secret']        = '';
$conf['doorkeeper-key']      = '';
$conf['doorkeeper-secret']   = '';
$conf['doorkeeper-authurl']  = 'https://doorkeeper-provider.herokuapp.com/oauth/authorize';
$conf['doorkeeper-tokenurl'] = 'https://doorkeeper-provider.herokuapp.com/oauth/token';
$conf['mailRestriction']     = '';
$conf['plugin']['oauth']['mcneelaccounts-key'] = '';
$conf['plugin']['oauth']['mcneelaccounts-secret'] = '';
$conf['plugin']['oauth']['mcneelaccounts-authurl'] = 'https://accounts.rhino3d.com/oauth2/auth';
$conf['plugin']['oauth']['mcneelaccounts-tokenurl'] = 'https://accounts.rhino3d.com/oauth2/token';
$conf['plugin']['oauth']['mcneelaccounts-userinfourl'] = 'https://accounts.rhino3d.com/oauth2/userinfo';
$conf['plugin']['oauth']['rhinoaccounts-key'] = '';
$conf['plugin']['oauth']['rhinoaccounts-secret'] = '';
$conf['plugin']['oauth']['rhinoaccounts-authurl'] = 'https://accounts.rhino3d.com/oauth2/auth';
$conf['plugin']['oauth']['rhinoaccounts-tokenurl'] = 'https://accounts.rhino3d.com/oauth2/token';
$conf['plugin']['oauth']['rhinoaccounts-userinfourl'] = 'https://accounts.rhino3d.com/oauth2/userinfo';
$conf['singleService']       = '';
