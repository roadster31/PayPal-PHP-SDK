<?php

namespace PayPal\Api;

use PayPal\Common\PayPalModel;

/**
 * Class AgreementTransactions
 *
 * A resource representing agreement_transactions that is returned during a transaction search.
 *
 * @package PayPal\Api
 *
 * @property \PayPal\Api\AgreementTransaction[] agreement_transaction_list
 */
class AgreementTransactions extends PayPalModel
{
    /**
     * Array of agreement_transaction object.
     *
     * @param AgreementTransaction[] $agreement_transaction_list
     *
     * @return $this
     */
    public function setAgreementTransactionList($agreement_transaction_list)
    {
        $this->agreement_transaction_list = $agreement_transaction_list;
        return $this;
    }

    /**
     * Array of agreement_transaction object.
     *
     * @return AgreementTransaction[]
     */
    public function getAgreementTransactionList()
    {
        return $this->agreement_transaction_list;
    }

    /**
     * Append AgreementTransactionList to the list.
     *
     * @param AgreementTransaction $agreementTransaction
     * @return $this
     */
    public function addAgreementTransactionList($agreementTransaction)
    {
        if (!$this->getAgreementTransactionList()) {
            return $this->setAgreementTransactionList([$agreementTransaction]);
        } else {
            return $this->setAgreementTransactionList(
                array_merge($this->getAgreementTransactionList(), [$agreementTransaction])
            );
        }
    }

    /**
     * Remove AgreementTransactionList from the list.
     *
     * @param AgreementTransaction $agreementTransaction
     * @return $this
     */
    public function removeAgreementTransactionList($agreementTransaction)
    {
        return $this->setAgreementTransactionList(
            array_diff($this->getAgreementTransactionList(), [$agreementTransaction])
        );
    }

}
