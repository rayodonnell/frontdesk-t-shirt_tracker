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
				"disabled":""
			},
			{
				"name": "50 euro",
				"type": "+",
				"counttotal": "<?php echo getCount(2); ?>",
				"maxtotal": "0",
				"group":"1",
				"id":"2",
				"disabled":""
			},
	        {
		        "name": "50 euro",
		        "type": "+",
		        "counttotal": "<?php echo getCount(22); ?>",
		        "maxtotal": "0",
		        "group":"1",
		        "id":"22",
		        "disabled":""
	        },
	        {
		        "name": "100 euro",
		        "type": "+",
		        "counttotal": "<?php echo getCount(8); ?>",
		        "maxtotal": "0",
		        "group":"1",
		        "id":"8",
		        "disabled":""
	        },
	        {
		        "name": "vrije donatie",
		        "type": "+",
		        "counttotal": "<?php echo getCount(9); ?>",
		        "maxtotal": "0",
		        "group":"1",
		        "id":"9",
		        "disabled":""
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
					"name": "s",
					"type": "-",
					"counttotal": "<?php echo getCount(3); ?>",
					"maxtotal": "25",
					"group":"2",
					"id":"3",
					"disabled":""
				},
				{
					"name": "M",
					"type": "-",
					"counttotal": "<?php echo getCount(4); ?>",
					"maxtotal": "25",
					"group":"2",
					"id":"4",
					"disabled":""
				},
				{
					"name": "L",
					"type": "-",
					"counttotal": "<?php echo getCount(5); ?>",
					"maxtotal": "35",
					"group":"2",
					"id":"5",
					"disabled":""
				},
				{
					"name": "XL",
					"type": "-",
					"counttotal": "<?php echo getCount(6); ?>",
					"maxtotal": "25",
					"group":"2",
					"id":"6",
					"disabled":""
				},
				{
					"name": "XXL",
					"type": "-",
					"counttotal": "<?php echo getCount(7); ?>",
					"maxtotal": "25",
					"group":"2",
					"id":"7",
					"disabled":""
				},
		        {
			        "name": "XXXL",
			        "type": "-",
			        "counttotal": "<?php echo getCount(10); ?>",
			        "maxtotal": "25",
			        "group":"2",
			        "id":"10",
			        "disabled":""
		        },
		        {
			        "name": "XXXXL",
			        "type": "-",
			        "counttotal": "<?php echo getCount(12); ?>",
			        "maxtotal": "25",
			        "group":"2",
			        "id":"12",
			        "disabled":""
		        }
        ]
      },
	  {
		  "name": "Requests",
		  "group":"3",
		  "totalcount":"<?php echo getCountTotal(3); ?>",
		  "visible":"<?php echo getVisible(3); ?>",
		  "blobs": [
			  {
				  "name": "S",
				  "type": "+",
				  "counttotal": "<?php echo getCount(11); ?>",
				  "maxtotal": "0",
				  "group":"3",
				  "id":"11",
				  "disabled":""
			  }
		  ]
	  }
    ]
}