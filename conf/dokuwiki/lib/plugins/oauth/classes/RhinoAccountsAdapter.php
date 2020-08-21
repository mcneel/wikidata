<?php

namespace OAuth\Plugin;

use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Http\Exception\TokenResponseException;
use OAuth\Common\Service\AbstractService;
use OAuth\Common\Storage\Session;
use OAuth\ServiceFactory;
use OAuth\OAuth2\Service\RhinoAccounts;

/**
 * Class DoorkeeperAdapter
 *
 * This is an example on how to implement your own adapter for making DokuWiki login against
 * a custom oAuth provider. The used Generic Service backend expects the authorization and
 * token endpoints to be configured in the DokuWiki backend.
 *
 * Your custom API to access user data has to be implemented in the getUser function. The one here
 * is setup to work with the demo setup of the "Doorkeeper" ruby gem.
 *  
 *  AJ: This file has been modified to work with Rhino Accounts.
 *
 * @link https://github.com/doorkeeper-gem/doorkeeper
 * @package OAuth\Plugin
 */
class RhinoAccountsAdapter extends AbstractAdapter {

    /**
     * Retrieve the user's data
     *
     * The array needs to contain at least 'user', 'mail', 'name' and optional 'grps'
     *
     * @return array
     */
    public function getUser() {
        $JSON = new \JSON(JSON_LOOSE_TYPE);
        $data = array();

        /** var OAuth\OAuth2\Service\Generic $this->oAuth */
        $result = $JSON->decode($this->oAuth->request($this->hlp->getUserInfoEndpoint('RhinoAccounts')));

        $data['user'] = strtolower($result['name']);
        $data['name'] = $result['name'];
        $data['mail'] = $result['email'];

        return $data;
    }

    
    /**
     * Return the scope to request
     *
     * This should return the minimal scope needed for accessing the user's data
     *
     * @return array
     */
     
    public function getScope() {
        return array(RhinoAccounts::SCOPE_EMAIL, RhinoAccounts::SCOPE_PROFILE);
    }

    public function login() {
        $parameters = array();
        $parameters['state'] = urlencode(base64_encode(md5(rand())));
        $this->storage->storeAuthorizationState('RhinoAccounts', $parameters['state']);

        $url = $this->oAuth->getAuthorizationUri($parameters);
        send_redirect($url);
    }

}
