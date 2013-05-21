$Id: README.txt,v 1.1 2009/02/24 01:11:18 jtsnow Exp $

----------------------
Ubercart Price Quotes
----------------------
  Developed by ZivTech - http://www.zivtech.com

SUMMARY:

  Ubercart Quotes was developed by ZivTech for BlueCadet. Its purpose is to allow 
customers to request a price quote for a product via the Ubercart shopping cart.

REQUIREMENTS:
  -Ubercart
  -Drupal 6
  
INSTALLATION:
  If you have not already done so, install Ubercart. Also make sure that the
  Ubercart Product module is installed.
  Copy the unzipped uc_quotes folder to the modules/ubercart/contrib folder.
  Enable the module via the Administer >> Site Building >> Modules page.
  
CONFIGURATION:
  When a product requires a price quote, the "Add to Cart" button text is replaced
  with "Add to Quote" by default. 
  
  When a customer views his or her shopping cart, some text is also appended to the
  product title to indicate to the customer that it is a price quote request. By 
  default, it is "(Price Inquiry)".
  
  You may change both of these options by directing your browser to the 
  Administer >> Store administration >> Configuration >> Product settings >> Product Features page
  (admin/store/settings/products/edit/features).
  
USAGE:
  After you have created one or more products for your store, edit a product that
  will require a price quote. Click the 'Features' tab. In the 'Add a new feature'
  drop down menu, select 'Price Quote' and click the "Add" button.
  Next, check the 'Quotable product' check box and click the "Save Feature" button.
  
  Now, customers will be able to request a price quote for this product by adding it to
  their shopping cart. The price should most likely be set to $0 and the price quote
  will be added to the cart as a non-shippable item.
  
CONTACT:
   Developers:
   * Jody Hamilton (Lynn) - jody@zivtech.com
   * John Snow (jtsnow) - john@zivtech.com
   
   Maintainers:
   * Alex Urevick-Ackelsberg (Alex UA) - alex@zivtech.com
   * Jody Hamilton (Lynn) - jody@zivtech.com
   * John Snow (jtsnow) - john@zivtech.com
   * Aaron Couch (acouch) - aaron@zivtech.com


Releases may be downloaded at http://drupal.org/project/uc_quotes

