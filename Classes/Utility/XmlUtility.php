<?php
/*
 * Copyright (c) 2023 Andreas Sommer <sommer@belsignum.com>, belsignum UG
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 */

namespace Belsignum\ContainerBackground\Utility;

use RuntimeException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class XmlUtility
{
    public const APPEND_NODE_POSITION_BEFORE = 'before';
    public const APPEND_NODE_POSITION_AFTER = 'after';


    /**
     * @param string $baseFile Path to base file
     * @param string $additionalFile Path to file to add
     * @param string $node $xml node name
     * @param string $position (before|after)
     * @return string XML string
     */
    public static function mergeXml(
        string $baseFile,
        string $additionalFile,
        string $node = 'sDEF',
        string $position = self::APPEND_NODE_POSITION_AFTER
    ): string
    {
        try
        {
            $baseFileData = self::getXmlFromFile($baseFile);
            $additionalFileData = self::getXmlFromFile($additionalFile);
        }
        catch (RuntimeException $exception)
        {
            throw $exception;
        }

        $newSheets = [];

        foreach ($baseFileData['sheets'] as $nodeName => $sheet)
        {
            if ($node === $nodeName)
            {
                if ($position === self::APPEND_NODE_POSITION_BEFORE)
                {
                    self::addSheets($additionalFileData['sheets'], $newSheets);
                }

                $newSheets[$nodeName] = $sheet;

                if ($position === self::APPEND_NODE_POSITION_AFTER)
                {
                    self::addSheets($additionalFileData['sheets'], $newSheets);
                }
            }
            else
            {
                $newSheets[$nodeName] = $sheet;
            }
        }
        $baseFileData['sheets'] = $newSheets;
        return GeneralUtility::array2xml($baseFileData, '', 0, 'T3DataStructure');
    }

    /**
     * @param string $file
     * @return array
     */
    protected static function getXmlFromFile(string $file): array
    {
        // Resolve FILE: prefix pointing to a DS in a file
        if (str_starts_with(trim($file), 'FILE:'))
        {
            $fileName = substr(trim($file), 5);
            $file = GeneralUtility::getFileAbsFileName($fileName);
            if (empty($file) || !is_file($file))
            {
                throw new RuntimeException(
                    'Data structure file "' . $fileName . '" could not be resolved to an existing file',
                    1478105826
                );
            }
            $dataStructure = (string)file_get_contents($file);
            return GeneralUtility::xml2arrayProcess($dataStructure);
        }
        throw new RuntimeException(
            'Wrong resource file path format',
            1478105826
        );
    }

    /**
     * @param array $additionalSheets
     * @param array $sheets
     * @return void
     */
    protected static function addSheets(array $additionalSheets, array &$sheets): void
    {
        foreach ($additionalSheets as $node => $sheet)
        {
            $sheets[$node] = $sheet;
        }
    }

}