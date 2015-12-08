<?php

/**
 * 2.67	Procedure Indications Section (V2)
 *
 * This section contains the reason(s) for the procedure or surgery. This section may include the preprocedure
 * diagnoses as well as symptoms contributing to the reason for the procedure.
 *
 * Contains:
 * Indication (V2)
 *
 */

namespace LevelSection;

use LevelEntry;
use Exception;

class procedureFindings
{

    /**
     * @param $PortionData
     */
    private static function Validate($PortionData)
    {

    }

    /**
     * Build the Narrative part of this section
     * @param $PortionData
     */
    public static function Narrative($PortionData)
    {

    }

    /**
     * @return array
     */
    public static function Structure()
    {
        return [
            'ProcedureFindings' => [

            ]
        ];
    }

    /**
     * @param $PortionData
     * @param $CompleteData
     * @return array|Exception
     */
    public static function Insert($PortionData, $CompleteData)
    {
        try
        {
            // Validate first
            self::Validate($PortionData);

            $Section = [
                'component' => [
                    'section' => [
                        'templateId' => [
                            '@attributes' => [
                                'root' => '2.16.840.1.113883.10.20.22.2.29.2',
                                'extension' => $PortionData['ProcedureIndications']['date']
                            ]
                        ],
                        'code' => [
                            '@attributes' => [
                                'code' => '59768-2',
                                'codeSystem' => '2.16.840.1.113883.6.1',
                                'codeSystemName' => 'LOINC',
                                'displayName' => 'Procedure Indications'
                            ]
                        ],
                        'title' => 'Procedure Indications',
                        'text' => self::Narrative($PortionData['ProcedureIndications'])
                    ]
                ]
            ];

            // Indication (V2)
            if(count($PortionData['ProcedureIndications']['Indications'])>1) {
                foreach ($PortionData['ProcedureIndications']['Indications'] as $Indication) {
                    $Section['component']['section']['entry'][] = LevelEntry\indication::Insert(
                        $Indication,
                        $CompleteData
                    );
                }
            }

            return $Section;
        }
        catch (Exception $Error)
        {
            return $Error;
        }
    }

}
