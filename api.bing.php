    <?php


//https://api.datamarket.azure.com/Data.ashx/Bing/Search/v1/Web?$format=json&$top=8&Query
//https://api.datamarket.azure.com/Bing/Search/v1/Image?Query=%27AMC%20Pacer%203.8%201978%27


    // Replace this value with your account key
    $accountKey = 'NpSpHd61lP/B/fWw5GHb9wF1nEyg6OViXw1GNW6ZLtE';
    $ServiceRootURL =  'https://api.datamarket.azure.com/Bing/Search/v1/';  
    $WebSearchURL = $ServiceRootURL . 'Image?$format=json&Query=';

    $request = $WebSearchURL . urlencode( '\'' . $_GET["q"] . '\'');

    $process = curl_init($request);
    curl_setopt($process, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($process, CURLOPT_USERPWD,  $accountKey . ":" . $accountKey);
    curl_setopt($process, CURLOPT_TIMEOUT, 30);
    curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($process);

    //echo $response;

    $jsonobj = json_decode($response);

    echo('<ul ID="resultList">');

    foreach($jsonobj->d->results as $value)
    {                        
        //<img src="' . $value->MediaUrl . '">
        echo('<li class="resultlistitem">
            <img src="' . $value->Thumbnail->MediaUrl . '">
            </li>');
    }

    echo("</ul>");
    ?>