<?php
/**
* File: FarmerModel.php
* Author: Satyapriya Baral
* Path: App/FMUser.php
* Purpose: fetches data from filemaker database and serves to controller
* Date: 16-03-2017
*/

namespace App\Model;

use App\Classes\FilemakerWrapper;
use FileMaker;

/**
* Class containing all functions to connect to filemaker.
*/
class UserModel
{

    /**
    * Function to Show all user Details.
    *
    * @param string $layout - contains name of the layout.
    * @param array $input - contains all the fields to search the user
    * @return - Filemaker results of all records found.
    */
    public static function userDetails($layout, $input)
    {
        $fmobj = FilemakerWrapper::getConnection();
        //command to find according to criterion
        $cmd = $fmobj->newFindCommand($layout);
        $cmd->addFindCriterion('UserEmail_xt', '=='.$input['Email']);
        $cmd->addFindCriterion('UserPassword_xt', '=='.$input['Password']);
        $result = $cmd->execute();

        if (!FileMaker::isError($result)) {
            return $result->getRecords();
        }
        return false;
    }
    /**
    * Function to Create a User.
    *
    * @param string $layout - contains name of the layout.
    * @param array $input - Contains all the data to be inserted in the record.
    * @return - Boolian value if any error occured or not.
    */
    public static function addUsers($layout, $input)
    {
        $fmobj = FilemakerWrapper::getConnection();
        $request = $fmobj->createRecord($layout);

        //sets all field of the new user
        $request->setField('__kfn_UserType', UserModel::sanitize($input['UserType']));
        $request->setField('UserName_xt', UserModel::sanitize($input['Name']));
        $request->setField('UserPassword_xt', UserModel::sanitize($input['Password']));
        $request->setField('UserContact_xn', UserModel::sanitize($input['Number']));
        $request->setField('UserAddress_xt', UserModel::sanitize($input['Address']));
        $request->setField('UserEmail_xt', UserModel::sanitize($input['Email']));
        $request->setField('EnableDisable_xn', 0);
        $request->setField('UserRating_n', 0);
        $result = $request->commit();

        if (!FileMaker::isError($result)) {
            return true;
        }
        return $result->getMessage();
    }

    /**
    * Function to search for data in some find criterion.
    *
    * @param string $layout - contains name of the layout.
    * @param string $data - contains email data.
    * @param string $field - contains the field on whose basis to be searched.
    * @return - Boolian value if the result is found or not.
    */
    public static function find($layout, $data, $field)
    {
        $fmobj = FilemakerWrapper::getConnection();
        $cmd = $fmobj->newFindCommand($layout);
        //find records according to criterion
        $cmd->addFindCriterion($field, "==".$data);
        $result = $cmd->execute();

        if (!FileMaker::isError($result)) {
            return $result->getRecords();
        }
        return false;
    }

    /**
    * Function to edit the user layot to add token.
    *
    * @param string $layout - contains name of the layout.
    * @param string token - contains the random token value.
    * @param int $UserId - Contains the id of the user.
    * @return - Boolian value if any error occured or not.
    */
    public static function edit($layout, $token, $Id)
    {
        $fmobj = FilemakerWrapper::getConnection();
        $request = $fmobj->newEditCommand($layout, $Id);

        $request->setField('token_t', $token);
        $result = $request->execute();

        if (!FileMaker::isError($result)) {
            return true;
        }
        return $result->getMessage();
    }

    /**
    * Function to search for user.
    *
    * @param string $layout - contains name of the layout.
    * @param string $token - contains the random token value.
    * @param string $email - contains th email address of user.
    * @return - Boolian value if the result is found or not.
    */
    public static function findUser($layout, $token, $email)
    {
        $fmobj = FilemakerWrapper::getConnection();
        $cmd = $fmobj->newFindCommand($layout);

        //find user for by its email and token number
        $cmd->addFindCriterion('UserEmail_xt', "==".$email);
        $cmd->addFindCriterion('token_t', "==".$token);
        $result = $cmd->execute();
        if (!FileMaker::isError($result)) {
            return $result->getRecords();
        }
        return false;
    }

    /**
    * Function to edit the password field.
    *
    * @param string $layout - contains name of the layout.
    * @param string $password - contains the new password.
    * @param int $rId - Contains the id of the user.
    * @return - Boolian value if any error occured or not.
    */
    public static function editPassword($layout, $password, $rId)
    {
        $fmobj = FilemakerWrapper::getConnection();
        $request = $fmobj->newEditCommand($layout, $rId);
        //setting the new password after changing
        $request->setField('UserPassword_xt', $password);
        $result = $request->execute();

        if (!FileMaker::isError($result)) {
            return true;
        }
        return $result->getMessage();
    }

    /**
    * Function to sanitize the value that will be stored in the database.
    *
    * @param mixed $value - contains the value to be sanitized.
    * @return - Returns the value after sanitizing.
    */
    public static function sanitize($value)
    {
        $retvar = trim($value);
        $retvar = strip_tags($retvar);
        $retvar = htmlspecialchars($retvar);
        return $retvar;
    }
}
