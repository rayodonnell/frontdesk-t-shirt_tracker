<?php
include("../inc/functions.php");
?>
{
  "category": [
      {
        "name": "Donations",
        "group":"1",
        "totalcount":"<?php echo getCountTotal(1); ?>",
	    "visible":"<?php echo getVisible(1); ?>",
        "blobs": [
			{
				"name": "25 euro",
				"type": "+",
				"counttotal": "<?php echo getCount(1); ?>",
				"maxtotal": "0",
				"group":"1",
				"id":"1",
				"disabled":"",
                "print":"temp1",
                "print2":"none"
			},
			{
				"name": "50 euro",
				"type": "+",
				"counttotal": "<?php echo getCount(2); ?>",
				"maxtotal": "0",
				"group":"1",
				"id":"2",
				"disabled":"",
                "print":"temp1",
                "print2":"temp2"
			},
	        {
		        "name": "50 euro (hoodie)",
		        "type": "+",
		        "counttotal": "<?php echo getCount(22); ?>",
		        "maxtotal": "0",
		        "group":"1",
		        "id":"22",
		        "disabled":"",
                "print":"temp1",
                "print2":"none"
	        },
	        {
		        "name": "100 euro",
		        "type": "+",
		        "counttotal": "<?php echo getCount(8); ?>",
		        "maxtotal": "0",
		        "group":"1",
		        "id":"8",
		        "disabled":"",
                "print":"temp1",
                "print2":"temp4"
	        },
	        {
		        "name": "vrije donatie",
		        "type": "+",
		        "counttotal": "<?php echo getCount(9); ?>",
		        "maxtotal": "0",
		        "group":"1",
		        "id":"9",
		        "disabled":"",
                "print":"temp3",
                "print2":"none"
	        }
        ]
      },
      {
        "name": "T-shirts",
        "group":"2",
        "totalcount":"<?php echo getCountTotal(2); ?>",
	    "visible":"<?php echo getVisible(2); ?>",
        "blobs": [
            {
            "name": "S",
            "type": "-",
            "counttotal": "<?php echo getCount(201); ?>",
            "maxtotal": "125",
            "group":"2",
            "id":"201",
            "model":"male",
            "disabled":""
            },
            {
            "name": "M",
            "type": "-",
            "counttotal": "<?php echo getCount(202); ?>",
            "maxtotal": "550",
            "group":"2",
            "id":"202",
            "model":"male",
            "disabled":""
            },
            {
            "name": "L",
            "type": "-",
            "counttotal": "<?php echo getCount(203); ?>",
            "maxtotal": "525",
            "group":"2",
            "id":"203",
            "model":"male",
            "disabled":""
            },
            {
            "name": "XL",
            "type": "-",
            "counttotal": "<?php echo getCount(204); ?>",
            "maxtotal": "325",
            "group":"2",
            "id":"204",
            "model":"male",
            "disabled":""
            },
            {
            "name": "XXL",
            "type": "-",
            "counttotal": "<?php echo getCount(205); ?>",
            "maxtotal": "175",
            "group":"2",
            "id":"205",
"model":"male",
            "disabled":""
            },
            {
            "name": "Girly S",
            "type": "-",
            "counttotal": "<?php echo getCount(206); ?>",
            "maxtotal": "15",
            "group":"2",
            "id":"206",
"model":"female",
            "disabled":""
            },
            {
            "name": "Girly M",
            "type": "-",
            "counttotal": "<?php echo getCount(207); ?>",
            "maxtotal": "75",
            "group":"2",
            "id":"207",
"model":"female",
            "disabled":""
            },
            {
            "name": "Girly L",
            "type": "-",
            "counttotal": "<?php echo getCount(208); ?>",
            "maxtotal": "65",
            "group":"2",
            "id":"208",
"model":"female",
            "disabled":""
            },
            {
            "name": "Girly XL",
            "type": "-",
            "counttotal": "<?php echo getCount(209); ?>",
            "maxtotal": "35",
            "group":"2",
            "id":"209",
"model":"female",
            "disabled":""
            },
            {
            "name": "Girly XXL",
            "type": "-",
            "counttotal": "<?php echo getCount(210); ?>",
            "maxtotal": "25",
            "group":"2",
            "id":"210",
"model":"female",
            "disabled":""
            }
        ]
      },
        {
        "name": "Hoodies",
        "group":"3",
        "totalcount":"<?php echo getCountTotal(3); ?>",
        "visible":"<?php echo getVisible(3); ?>",
        "blobs": [
            {
            "name": "M",
            "type": "-",
            "counttotal": "<?php echo getCount(301); ?>",
            "maxtotal": "25",
            "group":"3",
            "id":"301",
            "disabled":""
            },
            {
            "name": "L",
            "type": "-",
            "counttotal": "<?php echo getCount(302); ?>",
            "maxtotal": "30",
            "group":"3",
            "id":"302",
            "disabled":""
            },
            {
            "name": "XL",
            "type": "-",
            "counttotal": "<?php echo getCount(303); ?>",
            "maxtotal": "30",
            "group":"3",
            "id":"303",
            "disabled":""
            },
            {
            "name": "XXL",
            "type": "-",
            "counttotal": "<?php echo getCount(304); ?>",
            "maxtotal": "15",
            "group":"3",
            "id":"304",
            "disabled":""
            }
            ]
        },
	  {
		  "name": "Requests",
		  "group":"4",
		  "totalcount":"<?php echo getCountTotal(4); ?>",
		  "visible":"<?php echo getVisible(4); ?>",
		  "blobs": [
                {
                "name": "S",
                "type": "+",
                "counttotal": "<?php echo getCount(401); ?>",
                "maxtotal": "0",
                "group":"4",
                "id":"401",
                "disabled":""
                },
                {
                "name": "M",
                "type": "+",
                "counttotal": "<?php echo getCount(402); ?>",
                "maxtotal": "0",
                "group":"4",
                "id":"402",
                "disabled":""
                },
                {
                "name": "L",
                "type": "+",
                "counttotal": "<?php echo getCount(403); ?>",
                "maxtotal": "0",
                "group":"4",
                "id":"403",
                "disabled":""
                },
                {
                "name": "XL",
                "type": "+",
                "counttotal": "<?php echo getCount(404); ?>",
                "maxtotal": "0",
                "group":"4",
                "id":"404",
                "disabled":""
                },
                {
                "name": "XXL",
                "type": "+",
                "counttotal": "<?php echo getCount(405); ?>",
                "maxtotal": "0",
                "group":"4",
                "id":"405",
                "disabled":""
                },
                {
                "name": "Girly S",
                "type": "+",
                "counttotal": "<?php echo getCount(406); ?>",
                "maxtotal": "0",
                "group":"4",
                "id":"406",
                "disabled":""
                },
                {
                "name": "Girly M",
                "type": "+",
                "counttotal": "<?php echo getCount(407); ?>",
                "maxtotal": "0",
                "group":"4",
                "id":"407",
                "disabled":""
                },
                {
                "name": "Girly L",
                "type": "+",
                "counttotal": "<?php echo getCount(408); ?>",
                "maxtotal": "0",
                "group":"4",
                "id":"408",
                "disabled":""
                },
                {
                "name": "Girly XL",
                "type": "+",
                "counttotal": "<?php echo getCount(409); ?>",
                "maxtotal": "0",
                "group":"4",
                "id":"409",
                "disabled":""
                },
                {
                "name": "Girly XXL",
                "type": "+",
                "counttotal": "<?php echo getCount(210); ?>",
                "maxtotal": "0",
                "group":"4",
                "id":"210",
                "disabled":""
                }
		  ]
	  }
    ]
}