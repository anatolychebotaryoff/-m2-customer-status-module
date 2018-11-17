<?php

$installer = $this;
$installer->startSetup();
$cmsPageDataArr = array(
    array(
        'title' => 'SmartFIT.com Help Page',
        'root_template' => 'one_column',
        'identifier' => 'help.html',
        'stores' => array(Mage::getModel('core/store')->load('sf_en')->getId()),
        'content' => '
        <p style="color: #ff0000; font-weight: bold; font-size: 13px">
            Please replace this text with your content of Help Page
        </p>
        <p>
            At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat…
        </p>
        '
    ),
    array(
        'title' => 'SmartFIT.com About Us Page',
        'root_template' => 'one_column',
        'identifier' => 'about_us.html',
        'stores' => array(Mage::getModel('core/store')->load('sf_en')->getId()),
        'content' => '
            <div class="page-head">
            <h2>About Magento  Demo Store</h2>
            </div>
            <div class="about-padd">
            <div class="wrapper">
            <div class="about-col-1">
            <h3>et dolore magna aliqua</h3>
            <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
            <span></span>
            </div>
            <div class="about-col-2">
            <h3>Ut enim ad minim ven</h3>
            <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
            <span></span>
            </div>
            <div class="about-col-3">
            <h3>quis nostrud exercitation </h3>
            <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
            </div>
            </div></div>
            <div class="about-padd-2">
            <div class="wrapper">
            <div class="about-col-4">
            <h4>d tempor incididunt ut </h4>
            <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
            <ul>
            <li>Lorem ipsum dolor sit amet</li>
            <li>Conse ctetur adipisicing elit sed</li>
            <li>Do eiusmod tempor </li>
            <li>Incididunt ut labore et dolore</li>
            </ul>
            <p>
            Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
            </p>
            </div>
            <div class="about-col-5">
            <h4>labore et dolore magna aliqua</h4>
            <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
            <ul>
            <li>Lorem ipsum dolor sit amet</li>
            <li>Conse ctetur adipisicing elit sed</li>
            <li>Do eiusmod tempor </li>
            <li>Incididunt ut labore et dolore</li>
            </ul>
            <p>
            Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
            </p>
            </div>
            <div class="about-col-6">
            <h4>Ut enim ad minim ven</h4>
            <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
            <ul>
            <li>Lorem ipsum dolor sit amet</li>
            <li>Conse ctetur adipisicing elit sed</li>
            <li>Do eiusmod tempor </li>
            <li>Incididunt ut labore et dolore</li>
            </ul>
            <p>
            Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
            </p>
            </div>
            </div>
            </div>
            <div class="about-col-7">
            <h4>tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ven</h4>
            <p>
            Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
            </p>
            </div>
        '
    ),
    array(
        'title' => 'SmartFIT.com Orders Returns Page',
        'root_template' => 'one_column',
        'identifier' => 'orders_returns.html',
        'stores' => array(Mage::getModel('core/store')->load('sf_en')->getId()),
        'content' => '
        <p style="color: #ff0000; font-weight: bold; font-size: 13px">
            Please replace this text with your content of Orders Returns Page
        </p>
        <p>
            At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat…
        </p>'
    ),
    array(
        'title' => 'SmartFIT.com Privacy Policy Page',
        'root_template' => 'one_column',
        'identifier' => 'privacy_policy.html',
        'stores' => array(Mage::getModel('core/store')->load('sf_en')->getId()),
        'content' => '
        <p style="color: #ff0000; font-weight: bold; font-size: 13px">
            Please replace this text with your Privacy Policy.
            Please add any additional cookies your website uses below (e.g., Google Analytics)
        </p>
        <p>
            This privacy policy sets out how {{config path="general/store_information/name"}} uses and protects any information
            that you give {{config path="general/store_information/name"}} when you use this website.
            {{config path="general/store_information/name"}} is committed to ensuring that your privacy is protected.
            Should we ask you to provide certain information by which you can be identified when using this website,
            then you can be assured that it will only be used in accordance with this privacy statement.
            {{config path="general/store_information/name"}} may change this policy from time to time by updating this page.
            You should check this page from time to time to ensure that you are happy with any changes.
        </p>
        <h2>What we collect</h2>
        <p>We may collect the following information:</p>
        <ul>
            <li>name</li>
            <li>contact information including email address</li>
            <li>demographic information such as postcode, preferences and interests</li>
            <li>other information relevant to customer surveys and/or offers</li>
        </ul>
        <p>
            For the exhaustive list of cookies we collect see the <a href="#list">List of cookies we collect</a> section.
        </p>
        <h2>What we do with the information we gather</h2>
        <p>
            We require this information to understand your needs and provide you with a better service,
            and in particular for the following reasons:
        </p>
        <ul>
            <li>Internal record keeping.</li>
            <li>We may use the information to improve our products and services.</li>
            <li>
                We may periodically send promotional emails about new products, special offers or other information which we
                think you may find interesting using the email address which you have provided.
            </li>
            <li>
                From time to time, we may also use your information to contact you for market research purposes.
                We may contact you by email, phone, fax or mail. We may use the information to customise the website
                according to your interests.
            </li>
        </ul>
        <h2>Security</h2>
        <p>
            We are committed to ensuring that your information is secure. In order to prevent unauthorised access or disclosure,
            we have put in place suitable physical, electronic and managerial procedures to safeguard and secure
            the information we collect online.
        </p>
        <h2>How we use cookies</h2>
        <p>
            A cookie is a small file which asks permission to be placed on your computers hard drive.
        Once you agree, the file is added and the cookie helps analyse web traffic or lets you know when you visit
            a particular site. Cookies allow web applications to respond to you as an individual. The web application
            can tailor its operations to your needs, likes and dislikes by gathering and remembering information about
            your preferences.
        </p>
        <p>
        We use traffic log cookies to identify which pages are being used. This helps us analyse data about web page traffic
        and improve our website in order to tailor it to customer needs. We only use this information for statistical
                                                                                                          analysis purposes and then the data is removed from the system.
        </p>
        <p>
        Overall, cookies help us provide you with a better website, by enabling us to monitor which pages you find useful
        and which you do not. A cookie in no way gives us access to your computer or any information about you,
            other than the data you choose to share with us. You can choose to accept or decline cookies.
        Most web browsers automatically accept cookies, but you can usually modify your browser setting
            to decline cookies if you prefer. This may prevent you from taking full advantage of the website.
        </p>
        <h2>Links to other websites</h2>
        <p>
        Our website may contain links to other websites of interest. However, once you have used these links
            to leave our site, you should note that we do not have any control over that other website.
        Therefore, we cannot be responsible for the protection and privacy of any information which you provide whilst
            visiting such sites and such sites are not governed by this privacy statement.
        You should exercise caution and look at the privacy statement applicable to the website in question.
        </p>
        <h2>Controlling your personal information</h2>
        <p>You may choose to restrict the collection or use of your personal information in the following ways:</p>
        <ul>
            <li>
        whenever you are asked to fill in a form on the website, look for the box that you can click to indicate
                that you do not want the information to be used by anybody for direct marketing purposes
        </li>
            <li>
                if you have previously agreed to us using your personal information for direct marketing purposes,
                                                                                        you may change your mind at any time by writing to or emailing us at
                {{config path="trans_email/ident_general/email"}}
            </li>
        </ul>
        <p>
        We will not sell, distribute or lease your personal information to third parties unless we have your permission
        or are required by law to do so. We may use your personal information to send you promotional information
            about third parties which we think you may find interesting if you tell us that you wish this to happen.
        </p>
        <p>
        You may request details of personal information which we hold about you under the Data Protection Act 1998.
            A small fee will be payable. If you would like a copy of the information held on you please write to
            {{config path="general/store_information/address"}}.
        </p>
        <p>
            If you believe that any information we are holding on you is incorrect or incomplete,
            please write to or email us as soon as possible, at the above address.
        We will promptly correct any information found to be incorrect.
        </p>
        <h2><a name="list"></a>List of cookies we collect</h2>
        <p>The table below lists the cookies we collect and what information they store.</p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>COOKIE name</th>
                    <th>COOKIE Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>CART</th>
                    <td>The association with your shopping cart.</td>
                </tr>
                <tr>
                    <th>CATEGORY_INFO</th>
                    <td>Stores the category info on the page, that allows to display pages more quickly.</td>
                </tr>
                <tr>
                    <th>COMPARE</th>
                    <td>The items that you have in the Compare Products list.</td>
                </tr>
                <tr>
                    <th>CURRENCY</th>
                    <td>Your preferred currency</td>
                </tr>
                <tr>
                    <th>CUSTOMER</th>
                    <td>An encrypted version of your customer id with the store.</td>
                </tr>
                <tr>
                    <th>CUSTOMER_AUTH</th>
                    <td>An indicator if you are currently logged into the store.</td>
                </tr>
                <tr>
                    <th>CUSTOMER_INFO</th>
                    <td>An encrypted version of the customer group you belong to.</td>
                </tr>
                <tr>
                    <th>CUSTOMER_SEGMENT_IDS</th>
                    <td>Stores the Customer Segment ID</td>
                </tr>
                <tr>
                    <th>EXTERNAL_NO_CACHE</th>
                    <td>A flag, which indicates whether caching is disabled or not.</td>
                </tr>
                <tr>
                    <th>FRONTEND</th>
                    <td>You sesssion ID on the server.</td>
                </tr>
                <tr>
                    <th>GUEST-VIEW</th>
                    <td>Allows guests to edit their orders.</td>
                </tr>
                <tr>
                    <th>LAST_CATEGORY</th>
                    <td>The last category you visited.</td>
                </tr>
                <tr>
                    <th>LAST_PRODUCT</th>
                    <td>The most recent product you have viewed.</td>
                </tr>
                <tr>
                    <th>NEWMESSAGE</th>
                    <td>Indicates whether a new message has been received.</td>
                </tr>
                <tr>
                    <th>NO_CACHE</th>
                    <td>Indicates whether it is allowed to use cache.</td>
                </tr>
                <tr>
                    <th>PERSISTENT_SHOPPING_CART</th>
                    <td>A link to information about your cart and viewing history if you have asked the site.</td>
                </tr>
                <tr>
                    <th>POLL</th>
                    <td>The ID of any polls you have recently voted in.</td>
                </tr>
                <tr>
                    <th>POLLN</th>
                    <td>Information on what polls you have voted on.</td>
                </tr>
                <tr>
                    <th>RECENTLYCOMPARED</th>
                    <td>The items that you have recently compared.            </td>
                </tr>
                <tr>
                    <th>STF</th>
                    <td>Information on products you have emailed to friends.</td>
                </tr>
                <tr>
                    <th>STORE</th>
                    <td>The store view or language you have selected.</td>
                </tr>
                <tr>
                    <th>USER_ALLOWED_SAVE_COOKIE</th>
                    <td>Indicates whether a customer allowed to use cookies.</td>
                </tr>
                <tr>
                    <th>VIEWED_PRODUCT_IDS</th>
                    <td>The products that you have recently viewed.</td>
                </tr>
                <tr>
                    <th>WISHLIST</th>
                    <td>An encrypted list of products added to your Wishlist.</td>
                </tr>
                <tr>
                    <th>WISHLIST_CNT</th>
                    <td>The number of items in your Wishlist.</td>
                </tr>
            </tbody>
        </table>'
    ),
    array(
        'title' => 'SmartFIT.com Customer Service Page',
        'root_template' => 'one_column',
        'identifier' => 'customer_service.html',
        'stores' => array(Mage::getModel('core/store')->load('sf_en')->getId()),
        'content' => '
            <div class="page-title">
             <h1>Customer Service</h1>
            </div>
            <ul class="custom-servis-ul">
            <li class="item-1">
            <h3>Shipping & Delivery</h3>
            <p>
            Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
            </p>
            <p>
            conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
            </p>
            </li>
            <li class="item-2">
            <h3>Privacy & Security</h3>
            <p>
            Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed doeiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate.
            </p>
            </li>
            <li class="item-3">
            <h3>Returns & Replacements</h3>
            <p>
            Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
            </p>
            <ul>
            <li>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor</li>
            <li>incididunt ut labore et dolore magna aliqua. </li>
            <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco</li>
            </ul>
            </li>
            <li class="item-4">
            <h3>Ordering</h3>
            <p>
            Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
            </li>
            <li class="item-5">
            <h3>Payment, Pricing & Promotions</h3>
            <p>
            Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
            </p>
            </li>
            <li class="item-6">
            <h3>Viewing Orders</h3>
            <p>
            Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
            </p>
            </li>
            <li class="item-7">
            <h3>Updating Account Information</h3>
            <p>
            Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
            </p>
            </li>
            </ul>'
    )
);

foreach ($cmsPageDataArr as $cmsPageData) {
    Mage::getModel('cms/page')->setData($cmsPageData)->save();
}

$installer->endSetup();