<?php
	# QUOTE OF THE DAY
	date_default_timezone_set('America/Los_Angeles');
	if (file_exists("data/qotd-data.php")) { include 'data/qotd-data.php'; } else { $old_date = 0; }
	if ($old_date === date("Y-m-d")){ # If quote already refreshed, show the quote of the day
		echo $quote;
	} else { # Else if QOTD hasn't been refreshed, generate a new quote and save it in /data/qotd-data.php

	$quotes = array( // PUT ALL QUOTES HERE; FORMAT: "\"Text.\\\" -Chinese Proverb",
		"1" => "\"Yesterday is history, tomorrow is a mystery, but today is a gift. That's why they call it the present.\\\" -Master Oogway",
		"2" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"3" => "\"Anyone who has never made a mistake has never tried anything new.\\\" -Albert Einstein",
		"4" => "\"Everything should be as simple as it is, but not simpler.\\\" -Albert Einstein",
		"5" => "\"Imagination is more important than knowledge. For knowledge is limited to all we now know and understand, while imagination embraces the entire world, and all there ever will be to know and understand.\\\" -Albert Einstein",
		"6" => "\"Insanity: doing the same thing over and over again and expecting different results.\\\" -Albert Einstein",
		"7" => "\"Learn from yesterday, live for today, hope for tomorrow. The important thing is not to stop questioning.\\\" -Albert Einstein",
		"8" => "\"Once we accept our limits, we go beyond them.\\\" -Albert Einstein",
		"9" => "\"Peace cannot be kept by force; it can only be achieved by understanding.\\\" -Albert Einstein",
		"10" => "\"The only source of knowledge is experience.\\\" -Albert Einstein",
		"11" => "\"Try not to become a man of success but rather to become a man of value.\\\" -Albert Einstein",
		"12" => "\"Experience is a hard teacher because she gives the test first, the lesson afterwards.\\\" -Vernon Sanders Law",
		"13" => "\"To know how much there is to know is the beginning of learning to live.”\\\" -Dorothy West",
		"14" => "\"Goal setting is the secret to a compelling future.\\\" -Tony Robins",
		"15" => "\"Life is about making an impact, not making an income.\\\" -Kevin Kruise",
		"16" => "\"Whatever the mind of man can conceive and believe, it can achieve.\\\" -Napoleon Hill",
		"17" => "\"The way to right wrongs is to turn the light of truth upon them.\\\" -Ida B. Wells",
		"18" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"19" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"20" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"21" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"22" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"23" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"24" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"25" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"26" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"27" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"28" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"29" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"30" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"31" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"32" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"33" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"34" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"35" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"36" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"37" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"38" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"39" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
		"40" => "\"The best time to plant a tree was 20 years ago. The second best time is now.\\\" -Chinese Proverb",
	);

	$data = "<?php \$old_date = \"" . date("Y-m-d") . "\"; \$quote = \"\\" . $quotes[rand(1,17)] . "\"; ?>"; # Store quote in PHP variable syntax
	$Handle = fopen("data/qotd-data.php", 'w'); // Set which folder data is stored in
	rewind($Handle);
	fwrite($Handle, $data); // Write data
	fclose($Handle); // Close
	include 'data/qotd-data.php'; # Update the quote
	echo $quote; # Show the quote and exit
} ?>