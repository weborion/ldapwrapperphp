# ldapwrapperphp

###This is core module file which takes use of PHP LDAP Functions to Authenticate wwith LDAP/Active Directory Server.

###The code has single Function validateLDAP which takes array $ldapsettings as input:

* $ldapsettings['ldap_host']="ldap.weborion.in";//LDAP Host e.g. ldap.weborion.in
* $ldapsettings['base_dn']="dc=weborion,dc=in";//BASE DN
* $ldapsettings['bind_dn']="cn=weborion";//BIND DN
* $ldapsettings['ldap_username']="user-name-goes-here";//username like username@companyname.com
* $ldapsettings['ldap_password']="password-goes-here";//User Password
* $ldapsettings['data_attribute']="cn";// Used in  Filter String 

* Returns String as output You can modify the return type as per your requirement
