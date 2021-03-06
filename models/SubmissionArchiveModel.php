<?php

namespace HeimrichHannot\Submissions;

use HeimrichHannot\Haste\Dca\General;

class SubmissionArchiveModel extends \Model
{

    protected static $strTable = 'tl_submission_archive';

    public static function findByParent($strTable, $intPid)
    {
        return static::findBy(['parentTable=?', 'pid=?'], [$strTable, $intPid]);
    }

    /**
     * @deprecated use SubmissionModel::findSubmissionsByParent()
     *
     * @param      $strTable
     * @param      $intPid
     * @param bool $blnPublishedOnly
     *
     * @return mixed
     */
    public static function findSubmissionsByParent($strTable, $intPid, $blnPublishedOnly = false)
    {
        return SubmissionModel::findSubmissionsByParent($strTable, $intPid, $blnPublishedOnly);
    }

    public static function getSubmissionFieldsByParent($strTable, $intPid)
    {
        if (($objSubmissionArchive = static::findByParent($strTable, $intPid)) !== null)
        {
            return deserialize($objSubmissionArchive->submissionFields, true);
        }
    }

    public static function getParentEntity($intArchive)
    {
        if (($objArchive = static::findByPk($intArchive)) === null || !$objArchive->parentTable || !$objArchive->pid)
        {
            return null;
        }

        return General::getModelInstance($objArchive->parentTable, $objArchive->pid);
    }

}