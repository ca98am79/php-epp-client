<?php
namespace Metaregistrar\EPP;
/*
<extension>
    <dnsbe:ext>
        <dnsbe:create>
            <dnsbe:contact>
                <dnsbe:type>licensee</dnsbe:type>
                <dnsbe:vat>BE 123 4576 5645</dnsbe:vat>
                <dnsbe:lang>nl</dnsbe:lang>
            </dnsbe:contact>
        </dnsbe:create>
    </dnsbe:ext>
</extension>


*/
class dnsbeEppTransferRequest extends eppTransferRequest {
    function __construct($operation, $object, $tech, $billing) {
        parent::__construct($operation, $object);
        $this->addDnsbeExtension($tech, $billing);
        $this->addSessionId();
    }


    public function addDnsbeExtension($tech, $billing) {
        $this->addExtension('xmlns:dnsbe', 'http://www.dns.be/xml/epp/dnsbe-1.0');
        $ext = $this->createElement('extension');
        $sidnext = $this->createElement('dnsbe:ext');
        $create = $this->createElement('dnsbe:transfer');
        $contact = $this->createElement('dnsbe:domain');
        $contact->appendChild($this->createElement('dnsbe:registrant', '#AUTO#'));
        $contact->appendChild($this->createElement('dnsbe:billing', $billing));
        $contact->appendChild($this->createElement('dnsbe:tech', $tech));

        $create->appendChild($contact);
        $sidnext->appendChild($create);
        $ext->appendChild($sidnext);
        $this->command->appendChild($ext);

    }

}