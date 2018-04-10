@foreach ($layers as $layer)
    $cData = getArrayValue("commisionSetting", "", $layer);
    $csJson = json_decode($cData, true);
    $caData = getArrayValue("costAllocationSetting", "", $layer);
    $casJson = json_decode($caData, true);
    
    $dt = (int)getArrayValue("depositBonusRateType", 0, $casJson);
    $rt = (int)getArrayValue("rebateRateType", 0, $casJson);
    $bt = (int)getArrayValue("bonusRateType", 0, $casJson);

    if ($dt  != 0 && $rt != 0 && $bt != 0) {
        $caTag = "<font color='green'>是</font>";
    } else {
        $caTag = "<font color='red'>否</font>";
    }

    $cTag = "<font color='red'>否</font>";
    $wTag = "<font color='red'>否</font>";

    foreach (getArrayValue("game", array(), $csJson) as $game=>$gData) {
        $commisionType = (int)getArrayValue("pumpingCommisionRateType", 0, $gData);
        $waterType = (int)getArrayValue("pumpingWaterRateType", 0, $gData);

        if ($commisionType == 2) {
            $cTag = "<font color='green'>是</font>";
        }
        if ($waterType == 2) {
            $wTag = "<font color='green'>是</font>";
        }

        if ($commisionType == 1 && (float)getArrayValue("pumpingCommisionFixedRate", 0, $gData) > 0) {
            $cTag = "<font color='green'>是</font>";
        }

        if ($waterType == 1 && (float)getArrayValue("pumpingWaterFixedRate", 0, $gData) > 0) {
            $wTag = "<font color='green'>是</font>";
        }

    }
