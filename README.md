# freeradius-web-ui
FreeRadius is an open source software used to authenticate users over a wide range of networks for different services. This is the most basic explanation I can think of and if you want to dig deep, please head over to:
http://freeradius.org/

FreeRadius is used to authenticate users for different services such as Wi-Fi networks, openVPN, LDAP, Active Directory etc. and the list goes on.

freeradius-web-ui is used to manage the users and NAS clients on the FreeRadius server. You can add, delete, reset password of users from the web-ui. You can also add, delete and edit NAS clients. The whole interface is build using Metro-UI which uses PHP as a backend. This makes the whole UI very light weight and lightning fast. Information for users, NAS clients etc. is stored in the database and all the secret information such as user passwords are stored in 'sha1' or 'md5' encryption.

Database currently supported is MySQL/MariaDB.
