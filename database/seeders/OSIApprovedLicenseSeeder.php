<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\OSIApprovedLicense;

class OSIApprovedLicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $licenses = [
            [
             "name"=> "1-clause BSD License"
            ],
            [
             "name"=> "Academic Free License v. 3.0"
            ],
            [
             "name"=> "Adaptive Public License 1.0"
            ],
            [
             "name"=> "Apache License, Version 2.0"
            ],
            [
             "name"=> "Apache Software License, version 1.1"
            ],
            [
             "name"=> "Apple Public Source License 2.0"
            ],
            [
             "name"=> "Artistic License 1.0"
            ],
            [
             "name"=> "Artistic License 2.0"
            ],
            [
             "name"=> "Artistic License (Perl) 1.0"
            ],
            [
             "name"=> "Attribution Assurance License"
            ],
            [
             "name"=> "Boost Software License 1.0"
            ],
            [
             "name"=> "BSD+Patent"
            ],
            [
             "name"=> "Cea Cnrs Inria Logiciel Libre License, version 2.1"
            ],
            [
             "name"=> "CERN Open Hardware Licence Version 2 – Permissive"
            ],
            [
             "name"=> "CERN Open Hardware Licence Version 2 – Strongly Reciprocal"
            ],
            [
             "name"=> "CERN Open Hardware Licence Version 2 – Weakly Reciprocal"
            ],
            [
             "name"=> "Common Development and Distribution License 1.0"
            ],
            [
             "name"=> "Common Public Attribution License Version 1.0"
            ],
            [
             "name"=> "Common Public License Version 1.0"
            ],
            [
             "name"=> "Computer Associates Trusted Open Source License 1.1"
            ],
            [
             "name"=> "Cryptographic Autonomy License"
            ],
            [
             "name"=> "CUA Office Public License"
            ],
            [
             "name"=> "Eclipse Public License -v 1.0"
            ],
            [
             "name"=> "Eclipse Public License version 2.0"
            ],
            [
             "name"=> "eCos License version 2.0"
            ],
            [
             "name"=> "Educational Community License, Version 1.0"
            ],
            [
             "name"=> "Educational Community License, Version 2.0"
            ],
            [
             "name"=> "Eiffel Forum License, version 1"
            ],
            [
             "name"=> "Eiffel Forum License, Version 2"
            ],
            [
             "name"=> "Entessa Public License Version. 1.0"
            ],
            [
             "name"=> "EU DataGrid Software License"
            ],
            [
             "name"=> "European Union Public License, version 1.2"
            ],
            [
             "name"=> "Fair License"
            ],
            [
             "name"=> "Frameworx License 1.0"
            ],
            [
             "name"=> "GNU Affero General Public License version 3"
            ],
            [
             "name"=> "GNU General Public License, version 1"
            ],
            [
             "name"=> "GNU General Public License version 2"
            ],
            [
             "name"=> "GNU General Public License version 3"
            ],
            [
             "name"=> "GNU Lesser General Public License version 2.1"
            ],
            [
             "name"=> "GNU Lesser General Public License version 3"
            ],
            [
             "name"=> "GNU LGPL"
            ],
            [
             "name"=> "GNU Library General Public License version 2"
            ],
            [
             "name"=> "Historical Permission Notice and Disclaimer"
            ],
            [
             "name"=> "IBM Public License Version 1.0"
            ],
            [
             "name"=> "Intel Open Source License"
            ],
            [
             "name"=> "IPA Font License"
            ],
            [
             "name"=> "ISC License"
            ],
            [
             "name"=> "Jabber Open Source License"
            ],
            [
             "name"=> "JAM License"
            ],
            [
             "name"=> "LaTeX Project Public License, Version 1.3c"
            ],
            [
             "name"=> "Lawrence Berkeley National Labs BSD Variant License"
            ],
            [
             "name"=> "Licence Libre du Québec – Permissive version 1.1"
            ],
            [
             "name"=> "Licence Libre du Québec – Réciprocité forte version 1.1"
            ],
            [
             "name"=> "Licence Libre du Québec – Réciprocité version 1.1"
            ],
            [
             "name"=> "Lucent Public License, Plan 9, version 1.0"
            ],
            [
             "name"=> "Lucent Public License Version 1.02"
            ],
            [
             "name"=> "Microsoft Public License"
            ],
            [
             "name"=> "Microsoft Reciprocal License"
            ],
            [
             "name"=> "MirOS License"
            ],
            [
             "name"=> "MIT No Attribution License"
            ],
            [
             "name"=> "MITRE Collaborative Virtual Workspace License"
            ],
            [
             "name"=> "Motosoto Open Source License"
            ],
            [
             "name"=> "Mozilla Public License 1.1"
            ],
            [
             "name"=> "Mozilla Public License 2.0"
            ],
            [
             "name"=> "Mozilla Public License, version 1.0"
            ],
            [
             "name"=> "Mulan Permissive Software License v2"
            ],
            [
             "name"=> "Multics License"
            ],
            [
             "name"=> "NASA Open Source Agreement v1.3"
            ],
            [
             "name"=> "NAUMEN Public License"
            ],
            [
             "name"=> "Nokia Open Source License Version 1.0a"
            ],
            [
             "name"=> "Non-Profit Open Software License version 3.0"
            ],
            [
             "name"=> "NTP License"
            ],
            [
             "name"=> "Open Group Test Suite License"
            ],
            [
             "name"=> "OpenLDAP Public License Version 2.8"
            ],
            [
             "name"=> "Open Logistics Foundation License v1.3"
            ],
            [
             "name"=> "Open Software License 2.1"
            ],
            [
             "name"=> "Open Software License, version 1.0"
            ],
            [
             "name"=> "OSET Public License version 2.1"
            ],
            [
             "name"=> "PHP License 3.0"
            ],
            [
             "name"=> "PHP License 3.01"
            ],
            [
             "name"=> "Python License, Version 2"
            ],
            [
             "name"=> "RealNetworks Public Source License Version 1.0"
            ],
            [
             "name"=> "Reciprocal Public License 1.5"
            ],
            [
             "name"=> "Reciprocal Public License, version 1.1"
            ],
            [
             "name"=> "SIL OPEN FONT LICENSE"
            ],
            [
             "name"=> "Simple Public License"
            ],
            [
             "name"=> "Sun Industry Standards Source License"
            ],
            [
             "name"=> "Sun Public License, Version 1.0"
            ],
            [
             "name"=> "The 2-Clause BSD License"
            ],
            [
             "name"=> "The 3-Clause BSD License"
            ],
            [
             "name"=> "The CNRI portion of the multi-part Python License"
            ],
            [
             "name"=> "The European Union Public License, version 1.1"
            ],
            [
             "name"=> "The MIT License"
            ],
            [
             "name"=> "The Nethack General Public License"
            ],
            [
             "name"=> "The OCLC Research Public License 2.0 License"
            ],
            [
             "name"=> "The Open Software License 3.0"
            ],
            [
             "name"=> "The PostgreSQL Licence"
            ],
            [
             "name"=> "The Q Public License Version"
            ],
            [
             "name"=> "The Ricoh Source Code Public License"
            ],
            [
             "name"=> "The Sleepycat License"
            ],
            [
             "name"=> "The Sybase Open Source Licence"
            ],
            [
             "name"=> "The Universal Permissive License Version 1.0"
            ],
            [
             "name"=> "The University of Illinois\/NCSA Open Source License"
            ],
            [
             "name"=> "The Unlicense"
            ],
            [
             "name"=> "The Vovida Software License v. 1.0"
            ],
            [
             "name"=> "The W3C® SOFTWARE NOTICE AND LICENSE"
            ],
            [
             "name"=> "The wxWindows Library Licence"
            ],
            [
             "name"=> "The X.Net, Inc. License"
            ],
            [
             "name"=> "The zlib\/libpng License"
            ],
            [
             "name"=> "Unicode, Inc. License Agreement – Data Files and Software"
            ],
            [
             "name"=> "Upstream Compatibility License v1.0"
            ],
            [
             "name"=> "Zero-Clause BSD"
            ],
            [
             "name"=> "Zope Public License 2.0"
            ],
            [
             "name"=> "Zope Public License 2.1"
            ]
        ];

        OSIApprovedLicense::insert($licenses);
    }
}
