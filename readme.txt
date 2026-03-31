User Activity


Super Admin
	-Create Administrator Department Head Branch
	-Control accounts Access

Department Head
	-Post and control services of their respective Department (Visibility control by brand and local)
	-Create account assistant base on their authority level
	-Apply Ticket form Other Department
	-Monitor Tickets Request from other department
	-Monitor Staff Activity and Progress

Assistant/ Staff
	-Monitor tickets request based on Area Assigned
	-Apply tickets from other departments
	-Can do actions from the tickets request base on Authority given from Department Head
	-Track Activity Progress


Branch Level
	-Monitor tickets request progress
	-Apply tickets from other departments



Systems Audit
	-Monitor Progress of Tickets request and inapropiriate content
	-Create a report of incident




Ticket Progress Status Activity

	New - Meaning ticket was not yet opened of viewed
	Review - Meaning ticket was already opened by department head or staff viewing context but it commit as accepted the ticket
	Stand by - Meaning ticket was temporarily stopped
	In Progress - Meaning ticket was already Approved by Department Head or Assistant 
	Rejected - Meaning the ticket was rejected with Description
	Resolved - Meaning the ticket was resolved if the requestor satisfied the work of the person with feedback and ratings then generate ticket code for encoding
	Closed - Meaning the ticker was already done executed by person after encoding the ticket code applied
	Cancelled-  Meaning the ticket was changed by requestor due to kind of reason, it has a description on it.

Ticket Status 2 "Prioritize/De Prioritize" - Controlled only the the departmend head or assistant with authority


Ticket Status Conditions Activity

	if Ticket status "New"
		-Cancellation was allowed
		-Eidt was allowed
	else Ticket status "Review"
		-Cannot cancel
		-Cannot Edit
	else Ticket status "Stand By"
		-No Action for requestor
	else Ticket status "In Progress"
		-No Action for requestor
	else Ticket status "Resolved"
		-No Action for requestor
		-Apply Feedback of execution and rating to the person
		-Give ticket reference number for encoding of person execute
	else Ticket status "Closed"
		-Viewing only for requestor
		-Encoded by the person the ticket reference number
	else Ticket status "Cancelled"
		-Requestor need a feedback for its reason