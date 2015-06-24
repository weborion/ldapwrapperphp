<?php
echo "LDAP PHP Wrapper Implementation";
$ldapsettings['ldap_host']="ldap.weborion.in";
$ldapsettings['base_dn']="dc=weborion,dc=in";
$ldapsettings['bind_dn']="cn=weborion";
$ldapsettings['ldap_username']="user-name-goes-here";
$ldapsettings['ldap_password']="password-goes-here";
$ldapsettings['data_attribute']="cn";
$ldapRes= validateLDAP($ldapsettings);
echo "Result";
var_dump($ldapRes);

function validateLDAP($ldapsettings)
     {
     	try
     	{
			//$ldapsettings = array_walk_recursive($ldapsettings,'custom_stripslashes');
			$ds = ldap_connect($ldapsettings['ldap_host']); // connnect to LDAP HOST
			
			$sr = trim($ldapsettings['data_attribute']);
			$bind_dn = stripslashes(trim($ldapsettings['bind_dn']));
			$ldap_user = stripslashes(trim($ldapsettings['ldap_username']));
			$ldap_pwd = stripslashes(trim($ldapsettings['ldap_password']));
			
			
			if ($ds) // If LDAP Connection Resource Successful Then Proceed Further 
			{ 
				$filter=$sr."=".$ldap_user;// Filter For connection string
				//$this->printLog(__LINE__,'LoggerForm','In Validate LDAP Function',"bind with with ($bind_dn,'PASSWORD-NOT-DISCLOSED' )",$this->getCurrentProjectName(),'');

				$set_protocol = ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);//Dont Remove Required For Active Directory Support
				$set_referal = ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);//Dont Remove Required For Active Directory Support

				if (@ldap_bind( $ds, $bind_dn, $ldap_pwd ) ) // Bind with BIND_DN and password
				{
					/* Patch for Sample User not authenticated Start */
					$srch_user = ldap_search($ds,trim($ldapsettings['base_dn']),trim($filter));// Search LDAP with Filter this was my requirement you can skip this step
					$info_sample_user = ldap_get_entries($ds, $srch_user); // Search for Entries
					$sample_user_dn=$info_sample_user[0]['dn'];// Get DN of First 
					//var_dump($sample_user_dn);
					/* Patch for Sample User not authenticated End */

					$tmpBind=explode(",",$bind_dn);
					array_shift($tmpBind);
					array_unshift($tmpBind,$filter);
					$test_user_bind=implode(",",$tmpBind);//Replaced  This Var with $sample_user_dn

					if($test_user == "")
					{
						return "Success || Connection Successful";
					}
					if($sample_user_dn == "" || $sample_user_dn == '0')
					{
						return "Success || Connection Successful <br/> Sample user authentication failed";
					}
					
					
					$suc_str = (ldap_bind( $ds, $sample_user_dn, $ldap_pwd)) ? "Success || Connection Successful <br/> Sample user authenticated" : "Success || Connection Successful <br/> Sample user authentication FAILED";
					
					return $suc_str;
				}
				else
				{
					
					return "Error || ".ldap_error($ds);
				}
				@ldap_close($ds);
		
			} 
			else {
				
				return "Error || ".ldap_error($ds);
			}
		}
		catch(Exception $e)
		{
			
			return "Error || ".ldap_error($ds);
		}
     }
