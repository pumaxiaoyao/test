<?php

function showCardList(){
    $page = array(
        makeHeaderPage(""),
        readHtml("bank/cardList"),
        makeFooterPage(""),
    );
    output(join("", $page));
}

function showbankPayment(){
    $page = array(
        makeHeaderPage(""),
        readHtml("bank/bankPayment"),
        makeFooterPage("bank_bankpayment_footer"),
    );
    output(join("", $page));
}

function showmerChant(){
    $page = array(
        makeHeaderPage(""),
        readHtml("bank/merChant"),
        makeFooterPage("bank_merChant_footer"),
    );
    output(join("", $page));
}

function showdeposit(){
    $page = array(
        makeHeaderPage(""),
        readHtml("bank/deposit"),
        makeFooterPage("bank_deposit_footer"),
    );
    output(join("", $page));
}
?>