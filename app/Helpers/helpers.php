<?php



// -------------- Start: Email Template -------------------
function getEmailTemplates($template=''){
    $templates=[
        'subscription_expired' => ['customer_name','customer_email','subscription_name','business_name'],
        'document_accepted'=>['customer_name','customer_email','document_name','business_name'],
        'document_rejected'=>['customer_name','customer_email','document_name','reason','business_name'],
    ];

    if($template){
        $templates=$templates[$template];
    }

    return $templates;
}
// -------------- End: Email Template -------------------