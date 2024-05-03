<?php

namespace illuminate\Support\Supports;

class Advance_config
{
    public static function date_format()
    {
                $data = [
                    "Y-m-d",
                    "d-m-Y",
                    "d/m/Y",
                    "Y/M/D",
                    "Y.M.D",
                    "D.M.Y",
                    "Y, M D",
                    "D, M Y",
                    "D, M d Y",
                    "D, d M Y",
                    "y-m-d",
                    "d-m-y",
                    "d/m/y",
                    "y/m/d"
                ];

                return $data;
        }

        public static function allowed_business()
        {
                    return [
                        'retail',
                        'restaurants'
                    ];
        }

}