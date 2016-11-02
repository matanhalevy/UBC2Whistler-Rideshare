#What did the project accomplish?
The project created a barebones ridesharing app with two users, that allows drivers to create/edit rideshares
and passengers to join the subsequent ride shares.


#How did the schema change?
- After consulting with our TA we decided to make Passenger and Driver separate tables because of the different relationships
and attributes.
- We also choose to remove the payment information table and instead just provide paypal and cash payment options.
- We removed the transaction table because it was redundant to the participates table.
- We merged Pickup and Rideshare because they were total participation.

#SQL Queries Used
- Join
- Selection
- Division
- Aggregation
- Nested Aggregation
- Update
- Delete

#Functional Dependencies
FD(licenseNum) -> (type, color)
FD(DID) -> (DID, licenseNum, email, password, phoneNum, name)
FD(PostalCode) -> (city, province)
FD(PID) -> (email, password, phoneNum, name)
FD(RID) -> (DID, postalCode, destination, price, address, rdate, rtime, seats, seatsLeft, Cdatetime)
FD(PID, RID) -> (Type)






