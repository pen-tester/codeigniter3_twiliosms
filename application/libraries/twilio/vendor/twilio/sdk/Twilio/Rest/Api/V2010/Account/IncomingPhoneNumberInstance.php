<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string accountSid
 * @property string addressRequirements
 * @property string apiVersion
 * @property boolean beta
 * @property string capabilities
 * @property \DateTime dateCreated
 * @property \DateTime dateUpdated
 * @property string friendlyName
 * @property string phoneNumber
 * @property string origin
 * @property string sid
 * @property string smsApplicationSid
 * @property string smsFallbackMethod
 * @property string smsFallbackUrl
 * @property string smsMethod
 * @property string smsUrl
 * @property string statusCallback
 * @property string statusCallbackMethod
 * @property string trunkSid
 * @property string uri
 * @property string voiceApplicationSid
 * @property boolean voiceCallerIdLookup
 * @property string voiceFallbackMethod
 * @property string voiceFallbackUrl
 * @property string voiceMethod
 * @property string voiceUrl
 * @property string emergencyStatus
 * @property string emergencyAddressSid
 */
class IncomingPhoneNumberInstance extends InstanceResource {
    /**
     * Initialize the IncomingPhoneNumberInstance
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid The unique sid that identifies this account
     * @param string $sid Fetch by unique incoming-phone-number Sid
     * @return \Twilio\Rest\Api\V2010\Account\IncomingPhoneNumberInstance 
     */
    public function __construct(Version $version, array $payload, $accountSid, $sid = null) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = array(
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'addressRequirements' => Values::array_get($payload, 'address_requirements'),
            'apiVersion' => Values::array_get($payload, 'api_version'),
            'beta' => Values::array_get($payload, 'beta'),
            'capabilities' => Values::array_get($payload, 'capabilities'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'phoneNumber' => Values::array_get($payload, 'phone_number'),
            'origin' => Values::array_get($payload, 'origin'),
            'sid' => Values::array_get($payload, 'sid'),
            'smsApplicationSid' => Values::array_get($payload, 'sms_application_sid'),
            'smsFallbackMethod' => Values::array_get($payload, 'sms_fallback_method'),
            'smsFallbackUrl' => Values::array_get($payload, 'sms_fallback_url'),
            'smsMethod' => Values::array_get($payload, 'sms_method'),
            'smsUrl' => Values::array_get($payload, 'sms_url'),
            'statusCallback' => Values::array_get($payload, 'status_callback'),
            'statusCallbackMethod' => Values::array_get($payload, 'status_callback_method'),
            'trunkSid' => Values::array_get($payload, 'trunk_sid'),
            'uri' => Values::array_get($payload, 'uri'),
            'voiceApplicationSid' => Values::array_get($payload, 'voice_application_sid'),
            'voiceCallerIdLookup' => Values::array_get($payload, 'voice_caller_id_lookup'),
            'voiceFallbackMethod' => Values::array_get($payload, 'voice_fallback_method'),
            'voiceFallbackUrl' => Values::array_get($payload, 'voice_fallback_url'),
            'voiceMethod' => Values::array_get($payload, 'voice_method'),
            'voiceUrl' => Values::array_get($payload, 'voice_url'),
            'emergencyStatus' => Values::array_get($payload, 'emergency_status'),
            'emergencyAddressSid' => Values::array_get($payload, 'emergency_address_sid'),
        );

        $this->solution = array(
            'accountSid' => $accountSid,
            'sid' => $sid ?: $this->properties['sid'],
        );
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     * 
     * @return \Twilio\Rest\Api\V2010\Account\IncomingPhoneNumberContext Context
     *                                                                   for this
     *                                                                   IncomingPhoneNumberInstance
     */
    protected function proxy() {
        if (!$this->context) {
            $this->context = new IncomingPhoneNumberContext(
                $this->version,
                $this->solution['accountSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }

    /**
     * Update the IncomingPhoneNumberInstance
     * 
     * @param array|Options $options Optional Arguments
     * @return IncomingPhoneNumberInstance Updated IncomingPhoneNumberInstance
     */
    public function update($options = array()) {
        return $this->proxy()->update(
            $options
        );
    }

    /**
     * Fetch a IncomingPhoneNumberInstance
     * 
     * @return IncomingPhoneNumberInstance Fetched IncomingPhoneNumberInstance
     */
    public function fetch() {
        return $this->proxy()->fetch();
    }

    /**
     * Deletes the IncomingPhoneNumberInstance
     * 
     * @return boolean True if delete succeeds, false otherwise
     */
    public function delete() {
        return $this->proxy()->delete();
    }

    /**
     * Magic getter to access properties
     * 
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get($name) {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown property: ' . $name);
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $context = array();
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.IncomingPhoneNumberInstance ' . implode(' ', $context) . ']';
    }
}