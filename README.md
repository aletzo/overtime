A small app to display my career's overtime. Just out of curiousity for how much free work I've delivered over the years.

I keep a daily journal of my work in a simple text file (one file per year).

A typical entry for a day would look like this:

06-12-2016 (10:00 - 13:00, 14:00 - 19:00)
	[project1]:              PRJ1-ISSUE-1 (10:00 - 12:15)
	                         PRJ1-ISSUE-2 (12:15 - 13:00, 14:00 - 15:00)
	[project2]:              PRJ2-ISSUE-1 (15:00 - 18:30)
                             PRJ2-ISSUE-2 (18:30 - 19:00)

A entry for a day with overtime work might look like this:

07-12-2016 (10:15 - 13:30, 14:45 - 23:30)
	[project1]:              PRJ1-ISSUE-2 (10:15 - 12:00)
	[project2]:              PRJ2-ISSUE-2 (12:00 - 13:30)
                             PRJ2-ISSUE-3 (14:45 - 23:30)

This script simply parses the text given in $fileYEAR ($file2008, $file2009, etc) variables line by line and if the line begins with a properly formatted date, then the counts start summing up.
