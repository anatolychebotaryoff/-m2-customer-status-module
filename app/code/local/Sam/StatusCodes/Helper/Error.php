<?php

class Sam_StatusCodes_Helper_Error extends SFC_CyberSource_Helper_Gateway_Error
{

	public function mapErrorResponseToCustomerMessage(stdClass $response)
	{
		$reasonCode = (integer) $response->reasonCode;
		$defaultError = Mage::getStoreConfig('payment/' . SFC_CyberSource_Model_Method::METHOD_CODE . '/default_error');

        if(isset($response->ccAuthReply)) {
            $avsCode = $response->ccAuthReply->avsCode;
            switch ($avsCode) {
                case 'A':
                    return $this->getConfigByCode('a_code');
                case 'B':
                    return $this->getConfigByCode('b_code');
                case 'C':
                    return $this->getConfigByCode('c_code');
                case 'D':
                    return $this->getConfigByCode('d_code');
                case 'E':
                    return $this->getConfigByCode('e_code');
                case 'F':
                    return $this->getConfigByCode('f_code');
                case 'G':
                    return $this->getConfigByCode('g_code');
                case 'H':
                    return $this->getConfigByCode('h_code');
                case 'I':
                    return $this->getConfigByCode('i_code');
                case 'K':
                    return $this->getConfigByCode('k_code');
                case 'L':
                    return $this->getConfigByCode('l_code');
                case 'M':
                    return $this->getConfigByCode('m_code');
                case 'N':
                    return $this->getConfigByCode('n_code');
                case 'O':
                    return $this->getConfigByCode('o_code');
                case 'P':
                    return $this->getConfigByCode('p_code');
                case 'R':
                    return $this->getConfigByCode('r_code');
                case 'S':
                    return $this->getConfigByCode('s_code');
                case 'T':
                    return $this->getConfigByCode('t_code');
                case 'U':
                    return $this->getConfigByCode('u_code');
                case 'W':
                    return $this->getConfigByCode('w_code');
                case 'X':
                    return $this->getConfigByCode('x_code');
                case 'Y':
                    return $this->getConfigByCode('y_code');
                case 'Z':
                    return $this->getConfigByCode('z_code');
                default:
                    return $defaultError;
            }
        } elseif(isset($response->invalidField)) {
            $field = str_replace('c:billTo/c:', '', $response->invalidField);
            $result = preg_replace('/(?<!\ )[A-Z]/', ' $0', $field);
            $result = strtolower($result);
            Mage::register('sam_wrong_input', $field);
            $error = $this->__('Invalid data in %s field. Click %s to change it', $result, '<a id="statuscode-error" href="javascript:void(0);">here</a>');
            return $error;
        } else {
            return $defaultError;
        }
	}

	protected function getConfigByCode($code)
	{
		$resultCode = Mage::getStoreConfig('sam_statuscodes/general/' . $code);
		return $resultCode;
	}
}
