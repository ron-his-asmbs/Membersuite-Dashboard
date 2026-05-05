<?php
namespace ASMBS\Dashboard;

class MemberData
{
    public function fetch(): bool
    {
        $token = TokenService::getToken();
        $response = wp_remote_get(
            'https://rest.membersuite.com/crm/v1/individuals/' . $this->guid,
            [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'timeout' => 15,
            ]
        );

        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return false;
        }

        $this->data = json_decode(wp_remote_retrieve_body($response), true);
        return true;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    public function getFullName(): string
    {
        return trim(implode(' ', array_filter([
            $this->get('prefix'),
            $this->get('firstName'),
            $this->get('middleName'),
            $this->get('lastName'),
            $this->get('suffix'),
        ])));
    }

    public function getAddresses(): array
    {
        return array_filter([
            'Practice' => $this->get('practice_Address'),
            'Home'     => $this->get('home_Address'),
            'Other'    => $this->get('other_Address'),
        ]);
    }

    public function getPhones(): array
    {
        return array_filter([
            'Practice' => $this->get('practice_PhoneNumber'),
            'Home'     => $this->get('home_PhoneNumber'),
            'Mobile'   => $this->get('mobile_PhoneNumber'),
            'Fax'      => $this->get('fax_PhoneNumber'),
            'Other'    => $this->get('other_PhoneNumber'),
        ]);
    }

    public function getEmails(): array
    {
        return array_filter([
            $this->get('emailAddress'),
            $this->get('emailAddress2'),
            $this->get('emailAddress3'),
        ]);
    }

    public function getSocialLinks(): array
    {
        return array_filter([
            'Website'   => $this->get('webSite'),
            'Facebook'  => $this->get('facebookProfile'),
            'Twitter'   => $this->get('twitterHandle'),
            'LinkedIn'  => $this->get('linkedInProfile'),
            'Instagram' => $this->get('instagramProfile'),
        ]);
    }

    public function getSurgeryTypes(): array
    {
        return $this->get('surgeryTypes__c', []);
    }

    public function getRaces(): array
    {
        return $this->get('races__c', []);
    }

    public function getGender(): string
    {
        return $this->get('gender__c', '');
    }

    public function getDesignation(): string
    {
        return $this->get('designation', '');
    }

    public function getBoardCertifications(): array
    {
        return $this->get('boardCertifications__c', []);
    }

    public function getSocieties(): array
    {
        return $this->get('societies__c', []);
    }
}