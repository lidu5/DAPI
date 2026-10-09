<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ProgrammingLanguage;

class ProgrammingLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $programming_languages = [
          [
           "name"=> "A# .NET",
           "type"=> "Language"
          ],
          [
           "name"=> "A# (Axiom)",
           "type"=> "Language"
          ],
          [
           "name"=> "A-0 System",
           "type"=> "Language"
          ],
          [
           "name"=> "A+",
           "type"=> "Language"
          ],
          [
           "name"=> "A++",
           "type"=> "Language"
          ],
          [
           "name"=> "ABAP",
           "type"=> "Language"
          ],
          [
           "name"=> "ABC",
           "type"=> "Language"
          ],
          [
           "name"=> "ABC ALGOL",
           "type"=> "Language"
          ],
          [
           "name"=> "ABLE",
           "type"=> "Language"
          ],
          [
           "name"=> "ABSET",
           "type"=> "Language"
          ],
          [
           "name"=> "ABSYS",
           "type"=> "Language"
          ],
          [
           "name"=> "ACC",
           "type"=> "Language"
          ],
          [
           "name"=> "Accent",
           "type"=> "Language"
          ],
          [
           "name"=> "Ace DASL",
           "type"=> "Language"
          ],
          [
           "name"=> "ACL2",
           "type"=> "Language"
          ],
          [
           "name"=> "ACT-III",
           "type"=> "Language"
          ],
          [
           "name"=> "Action!",
           "type"=> "Language"
          ],
          [
           "name"=> "ActionScript",
           "type"=> "Language"
          ],
          [
           "name"=> "Ada",
           "type"=> "Language"
          ],
          [
           "name"=> "Adenine",
           "type"=> "Language"
          ],
          [
           "name"=> "Agda",
           "type"=> "Language"
          ],
          [
           "name"=> "Agilent VEE",
           "type"=> "Language"
          ],
          [
           "name"=> "Agora",
           "type"=> "Language"
          ],
          [
           "name"=> "AIMMS",
           "type"=> "Language"
          ],
          [
           "name"=> "Alef",
           "type"=> "Language"
          ],
          [
           "name"=> "ALF",
           "type"=> "Language"
          ],
          [
           "name"=> "ALGOL 58",
           "type"=> "Language"
          ],
          [
           "name"=> "ALGOL 60",
           "type"=> "Language"
          ],
          [
           "name"=> "ALGOL 68",
           "type"=> "Language"
          ],
          [
           "name"=> "ALGOL W",
           "type"=> "Language"
          ],
          [
           "name"=> "Alice",
           "type"=> "Language"
          ],
          [
           "name"=> "Alma-0",
           "type"=> "Language"
          ],
          [
           "name"=> "AmbientTalk",
           "type"=> "Language"
          ],
          [
           "name"=> "Amiga E",
           "type"=> "Language"
          ],
          [
           "name"=> "AMOS",
           "type"=> "Language"
          ],
          [
           "name"=> "AMPL",
           "type"=> "Language"
          ],
          [
           "name"=> "APL",
           "type"=> "Language"
          ],
          [
           "name"=> "App Inventor for Android's visual block language",
           "type"=> "Language"
          ],
          [
           "name"=> "AppleScript",
           "type"=> "Language"
          ],
          [
           "name"=> "Arc",
           "type"=> "Language"
          ],
          [
           "name"=> "ARexx",
           "type"=> "Language"
          ],
          [
           "name"=> "Argus",
           "type"=> "Language"
          ],
          [
           "name"=> "AspectJ",
           "type"=> "Language"
          ],
          [
           "name"=> "Assembly language",
           "type"=> "Language"
          ],
          [
           "name"=> "ATS",
           "type"=> "Language"
          ],
          [
           "name"=> "Ateji PX",
           "type"=> "Language"
          ],
          [
           "name"=> "AutoHotkey",
           "type"=> "Language"
          ],
          [
           "name"=> "Autocoder",
           "type"=> "Language"
          ],
          [
           "name"=> "AutoIt",
           "type"=> "Language"
          ],
          [
           "name"=> "AutoLISP \/ Visual LISP",
           "type"=> "Language"
          ],
          [
           "name"=> "Averest",
           "type"=> "Language"
          ],
          [
           "name"=> "AWK",
           "type"=> "Language"
          ],
          [
           "name"=> "Axum",
           "type"=> "Language"
          ],
          [
           "name"=> "B",
           "type"=> "Language"
          ],
          [
           "name"=> "Babbage",
           "type"=> "Language"
          ],
          [
           "name"=> "Bash",
           "type"=> "Language"
          ],
          [
           "name"=> "BASIC",
           "type"=> "Language"
          ],
          [
           "name"=> "bc",
           "type"=> "Language"
          ],
          [
           "name"=> "BCPL",
           "type"=> "Language"
          ],
          [
           "name"=> "BeanShell",
           "type"=> "Language"
          ],
          [
           "name"=> "Batch (Windows\/Dos)",
           "type"=> "Language"
          ],
          [
           "name"=> "Bertrand",
           "type"=> "Language"
          ],
          [
           "name"=> "BETA",
           "type"=> "Language"
          ],
          [
           "name"=> "Bigwig",
           "type"=> "Language"
          ],
          [
           "name"=> "Bistro",
           "type"=> "Language"
          ],
          [
           "name"=> "BitC",
           "type"=> "Language"
          ],
          [
           "name"=> "BLISS",
           "type"=> "Language"
          ],
          [
           "name"=> "Blue",
           "type"=> "Language"
          ],
          [
           "name"=> "Bon",
           "type"=> "Language"
          ],
          [
           "name"=> "Boo",
           "type"=> "Language"
          ],
          [
           "name"=> "Boomerang",
           "type"=> "Language"
          ],
          [
           "name"=> "Bourne shell",
           "type"=> "Language"
          ],
          [
           "name"=> "bash",
           "type"=> "Language"
          ],
          [
           "name"=> "ksh",
           "type"=> "Language"
          ],
          [
           "name"=> "BREW",
           "type"=> "Language"
          ],
          [
           "name"=> "BPEL",
           "type"=> "Language"
          ],
          [
           "name"=> "C",
           "type"=> "Language"
          ],
          [
           "name"=> "C--",
           "type"=> "Language"
          ],
          [
           "name"=> "C++",
           "type"=> "Language"
          ],
          [
           "name"=> "C#",
           "type"=> "Language"
          ],
          [
           "name"=> "C\/AL",
           "type"=> "Language"
          ],
          [
           "name"=> "Caché ObjectScript",
           "type"=> "Language"
          ],
          [
           "name"=> "C Shell",
           "type"=> "Language"
          ],
          [
           "name"=> "Caml",
           "type"=> "Language"
          ],
          [
           "name"=> "Candle",
           "type"=> "Language"
          ],
          [
           "name"=> "Cayenne",
           "type"=> "Language"
          ],
          [
           "name"=> "CDuce",
           "type"=> "Language"
          ],
          [
           "name"=> "Cecil",
           "type"=> "Language"
          ],
          [
           "name"=> "Cel",
           "type"=> "Language"
          ],
          [
           "name"=> "Cesil",
           "type"=> "Language"
          ],
          [
           "name"=> "Ceylon",
           "type"=> "Language"
          ],
          [
           "name"=> "CFEngine",
           "type"=> "Language"
          ],
          [
           "name"=> "CFML",
           "type"=> "Language"
          ],
          [
           "name"=> "Cg",
           "type"=> "Language"
          ],
          [
           "name"=> "Ch",
           "type"=> "Language"
          ],
          [
           "name"=> "Chapel",
           "type"=> "Language"
          ],
          [
           "name"=> "CHAIN",
           "type"=> "Language"
          ],
          [
           "name"=> "Charity",
           "type"=> "Language"
          ],
          [
           "name"=> "Charm",
           "type"=> "Language"
          ],
          [
           "name"=> "Chef",
           "type"=> "Language"
          ],
          [
           "name"=> "CHILL",
           "type"=> "Language"
          ],
          [
           "name"=> "CHIP-8",
           "type"=> "Language"
          ],
          [
           "name"=> "chomski",
           "type"=> "Language"
          ],
          [
           "name"=> "ChucK",
           "type"=> "Language"
          ],
          [
           "name"=> "CICS",
           "type"=> "Language"
          ],
          [
           "name"=> "Cilk",
           "type"=> "Language"
          ],
          [
           "name"=> "CL",
           "type"=> "Language"
          ],
          [
           "name"=> "Claire",
           "type"=> "Language"
          ],
          [
           "name"=> "Clarion",
           "type"=> "Language"
          ],
          [
           "name"=> "Clean",
           "type"=> "Language"
          ],
          [
           "name"=> "Clipper",
           "type"=> "Language"
          ],
          [
           "name"=> "CLIST",
           "type"=> "Language"
          ],
          [
           "name"=> "Clojure",
           "type"=> "Language"
          ],
          [
           "name"=> "CLU",
           "type"=> "Language"
          ],
          [
           "name"=> "CMS-2",
           "type"=> "Language"
          ],
          [
           "name"=> "COBOL",
           "type"=> "Language"
          ],
          [
           "name"=> "Cobra",
           "type"=> "Language"
          ],
          [
           "name"=> "CODE",
           "type"=> "Language"
          ],
          [
           "name"=> "CoffeeScript",
           "type"=> "Language"
          ],
          [
           "name"=> "Cola",
           "type"=> "Language"
          ],
          [
           "name"=> "ColdC",
           "type"=> "Language"
          ],
          [
           "name"=> "ColdFusion",
           "type"=> "Language"
          ],
          [
           "name"=> "COMAL",
           "type"=> "Language"
          ],
          [
           "name"=> "Combined Programming Language",
           "type"=> "Language"
          ],
          [
           "name"=> "COMIT",
           "type"=> "Language"
          ],
          [
           "name"=> "Common Intermediate Language",
           "type"=> "Language"
          ],
          [
           "name"=> "Common Lisp",
           "type"=> "Language"
          ],
          [
           "name"=> "COMPASS",
           "type"=> "Language"
          ],
          [
           "name"=> "Component Pascal",
           "type"=> "Language"
          ],
          [
           "name"=> "Constraint Handling Rules",
           "type"=> "Language"
          ],
          [
           "name"=> "Converge",
           "type"=> "Language"
          ],
          [
           "name"=> "Cool",
           "type"=> "Language"
          ],
          [
           "name"=> "Coq",
           "type"=> "Language"
          ],
          [
           "name"=> "Coral 66",
           "type"=> "Language"
          ],
          [
           "name"=> "Corn",
           "type"=> "Language"
          ],
          [
           "name"=> "CorVision",
           "type"=> "Language"
          ],
          [
           "name"=> "COWSEL",
           "type"=> "Language"
          ],
          [
           "name"=> "CPL",
           "type"=> "Language"
          ],
          [
           "name"=> "csh",
           "type"=> "Language"
          ],
          [
           "name"=> "CSP",
           "type"=> "Language"
          ],
          [
           "name"=> "Csound",
           "type"=> "Language"
          ],
          [
           "name"=> "CUDA",
           "type"=> "Language"
          ],
          [
           "name"=> "Curl",
           "type"=> "Language"
          ],
          [
           "name"=> "Curry",
           "type"=> "Language"
          ],
          [
           "name"=> "Cyclone",
           "type"=> "Language"
          ],
          [
           "name"=> "Cython",
           "type"=> "Language"
          ],
          [
           "name"=> "D",
           "type"=> "Language"
          ],
          [
           "name"=> "DASL",
           "type"=> "Language"
          ],
          [
           "name"=> "Dart",
           "type"=> "Language"
          ],
          [
           "name"=> "DataFlex",
           "type"=> "Language"
          ],
          [
           "name"=> "Datalog",
           "type"=> "Language"
          ],
          [
           "name"=> "DATATRIEVE",
           "type"=> "Language"
          ],
          [
           "name"=> "dBase",
           "type"=> "Language"
          ],
          [
           "name"=> "dc",
           "type"=> "Language"
          ],
          [
           "name"=> "DCL",
           "type"=> "Language"
          ],
          [
           "name"=> "Deesel",
           "type"=> "Language"
          ],
          [
           "name"=> "Delphi",
           "type"=> "Language"
          ],
          [
           "name"=> "DinkC",
           "type"=> "Language"
          ],
          [
           "name"=> "DIBOL",
           "type"=> "Language"
          ],
          [
           "name"=> "Dog",
           "type"=> "Language"
          ],
          [
           "name"=> "Draco",
           "type"=> "Language"
          ],
          [
           "name"=> "DRAKON",
           "type"=> "Language"
          ],
          [
           "name"=> "Dylan",
           "type"=> "Language"
          ],
          [
           "name"=> "DYNAMO",
           "type"=> "Language"
          ],
          [
           "name"=> "E",
           "type"=> "Language"
          ],
          [
           "name"=> "E#",
           "type"=> "Language"
          ],
          [
           "name"=> "Ease",
           "type"=> "Language"
          ],
          [
           "name"=> "Easy PL\/I",
           "type"=> "Language"
          ],
          [
           "name"=> "Easy Programming Language",
           "type"=> "Language"
          ],
          [
           "name"=> "EASYTRIEVE PLUS",
           "type"=> "Language"
          ],
          [
           "name"=> "ECMAScript",
           "type"=> "Language"
          ],
          [
           "name"=> "Edinburgh IMP",
           "type"=> "Language"
          ],
          [
           "name"=> "EGL",
           "type"=> "Language"
          ],
          [
           "name"=> "Eiffel",
           "type"=> "Language"
          ],
          [
           "name"=> "ELAN",
           "type"=> "Language"
          ],
          [
           "name"=> "Elixir",
           "type"=> "Language"
          ],
          [
           "name"=> "Elm",
           "type"=> "Language"
          ],
          [
           "name"=> "Emacs Lisp",
           "type"=> "Language"
          ],
          [
           "name"=> "Emerald",
           "type"=> "Language"
          ],
          [
           "name"=> "Epigram",
           "type"=> "Language"
          ],
          [
           "name"=> "EPL",
           "type"=> "Language"
          ],
          [
           "name"=> "Erlang",
           "type"=> "Language"
          ],
          [
           "name"=> "es",
           "type"=> "Language"
          ],
          [
           "name"=> "Escapade",
           "type"=> "Language"
          ],
          [
           "name"=> "Escher",
           "type"=> "Language"
          ],
          [
           "name"=> "ESPOL",
           "type"=> "Language"
          ],
          [
           "name"=> "Esterel",
           "type"=> "Language"
          ],
          [
           "name"=> "Etoys",
           "type"=> "Language"
          ],
          [
           "name"=> "Euclid",
           "type"=> "Language"
          ],
          [
           "name"=> "Euler",
           "type"=> "Language"
          ],
          [
           "name"=> "Euphoria",
           "type"=> "Language"
          ],
          [
           "name"=> "EusLisp Robot Programming Language",
           "type"=> "Language"
          ],
          [
           "name"=> "CMS EXEC",
           "type"=> "Language"
          ],
          [
           "name"=> "EXEC 2",
           "type"=> "Language"
          ],
          [
           "name"=> "Executable UML",
           "type"=> "Language"
          ],
          [
           "name"=> "F",
           "type"=> "Language"
          ],
          [
           "name"=> "F#",
           "type"=> "Language"
          ],
          [
           "name"=> "Factor",
           "type"=> "Language"
          ],
          [
           "name"=> "Falcon",
           "type"=> "Language"
          ],
          [
           "name"=> "Fancy",
           "type"=> "Language"
          ],
          [
           "name"=> "Fantom",
           "type"=> "Language"
          ],
          [
           "name"=> "FAUST",
           "type"=> "Language"
          ],
          [
           "name"=> "Felix",
           "type"=> "Language"
          ],
          [
           "name"=> "Ferite",
           "type"=> "Language"
          ],
          [
           "name"=> "FFP",
           "type"=> "Language"
          ],
          [
           "name"=> "Fjölnir",
           "type"=> "Language"
          ],
          [
           "name"=> "FL",
           "type"=> "Language"
          ],
          [
           "name"=> "Flavors",
           "type"=> "Language"
          ],
          [
           "name"=> "Flex",
           "type"=> "Language"
          ],
          [
           "name"=> "FLOW-MATIC",
           "type"=> "Language"
          ],
          [
           "name"=> "FOCAL",
           "type"=> "Language"
          ],
          [
           "name"=> "FOCUS",
           "type"=> "Language"
          ],
          [
           "name"=> "FOIL",
           "type"=> "Language"
          ],
          [
           "name"=> "FORMAC",
           "type"=> "Language"
          ],
          [
           "name"=> "@Formula",
           "type"=> "Language"
          ],
          [
           "name"=> "Forth",
           "type"=> "Language"
          ],
          [
           "name"=> "Fortran",
           "type"=> "Language"
          ],
          [
           "name"=> "Fortress",
           "type"=> "Language"
          ],
          [
           "name"=> "FoxBase",
           "type"=> "Language"
          ],
          [
           "name"=> "FoxPro",
           "type"=> "Language"
          ],
          [
           "name"=> "FP",
           "type"=> "Language"
          ],
          [
           "name"=> "FPr",
           "type"=> "Language"
          ],
          [
           "name"=> "Franz Lisp",
           "type"=> "Language"
          ],
          [
           "name"=> "Frege",
           "type"=> "Language"
          ],
          [
           "name"=> "F-Script",
           "type"=> "Language"
          ],
          [
           "name"=> "FSProg",
           "type"=> "Language"
          ],
          [
           "name"=> "G",
           "type"=> "Language"
          ],
          [
           "name"=> "Google Apps Script",
           "type"=> "Language"
          ],
          [
           "name"=> "Game Maker Language",
           "type"=> "Language"
          ],
          [
           "name"=> "GameMonkey Script",
           "type"=> "Language"
          ],
          [
           "name"=> "GAMS",
           "type"=> "Language"
          ],
          [
           "name"=> "GAP",
           "type"=> "Language"
          ],
          [
           "name"=> "G-code",
           "type"=> "Language"
          ],
          [
           "name"=> "Genie",
           "type"=> "Language"
          ],
          [
           "name"=> "GDL",
           "type"=> "Language"
          ],
          [
           "name"=> "Gibiane",
           "type"=> "Language"
          ],
          [
           "name"=> "GJ",
           "type"=> "Language"
          ],
          [
           "name"=> "GEORGE",
           "type"=> "Language"
          ],
          [
           "name"=> "GLSL",
           "type"=> "Language"
          ],
          [
           "name"=> "GNU E",
           "type"=> "Language"
          ],
          [
           "name"=> "GM",
           "type"=> "Language"
          ],
          [
           "name"=> "Go",
           "type"=> "Language"
          ],
          [
           "name"=> "Go!",
           "type"=> "Language"
          ],
          [
           "name"=> "GOAL",
           "type"=> "Language"
          ],
          [
           "name"=> "Gödel",
           "type"=> "Language"
          ],
          [
           "name"=> "Godiva",
           "type"=> "Language"
          ],
          [
           "name"=> "GOM (Good Old Mad)",
           "type"=> "Language"
          ],
          [
           "name"=> "Goo",
           "type"=> "Language"
          ],
          [
           "name"=> "Gosu",
           "type"=> "Language"
          ],
          [
           "name"=> "GOTRAN",
           "type"=> "Language"
          ],
          [
           "name"=> "GPSS",
           "type"=> "Language"
          ],
          [
           "name"=> "GraphTalk",
           "type"=> "Language"
          ],
          [
           "name"=> "GRASS",
           "type"=> "Language"
          ],
          [
           "name"=> "Groovy",
           "type"=> "Language"
          ],
          [
           "name"=> "Hack (programming language)",
           "type"=> "Language"
          ],
          [
           "name"=> "HAL\/S",
           "type"=> "Language"
          ],
          [
           "name"=> "Hamilton C shell",
           "type"=> "Language"
          ],
          [
           "name"=> "Harbour",
           "type"=> "Language"
          ],
          [
           "name"=> "Hartmann pipelines",
           "type"=> "Language"
          ],
          [
           "name"=> "Haskell",
           "type"=> "Language"
          ],
          [
           "name"=> "Haxe",
           "type"=> "Language"
          ],
          [
           "name"=> "High Level Assembly",
           "type"=> "Language"
          ],
          [
           "name"=> "HLSL",
           "type"=> "Language"
          ],
          [
           "name"=> "Hop",
           "type"=> "Language"
          ],
          [
           "name"=> "Hope",
           "type"=> "Language"
          ],
          [
           "name"=> "Hugo",
           "type"=> "Language"
          ],
          [
           "name"=> "Hume",
           "type"=> "Language"
          ],
          [
           "name"=> "HyperTalk",
           "type"=> "Language"
          ],
          [
           "name"=> "IBM Basic assembly language",
           "type"=> "Language"
          ],
          [
           "name"=> "IBM HAScript",
           "type"=> "Language"
          ],
          [
           "name"=> "IBM Informix-4GL",
           "type"=> "Language"
          ],
          [
           "name"=> "IBM RPG",
           "type"=> "Language"
          ],
          [
           "name"=> "ICI",
           "type"=> "Language"
          ],
          [
           "name"=> "Icon",
           "type"=> "Language"
          ],
          [
           "name"=> "Id",
           "type"=> "Language"
          ],
          [
           "name"=> "IDL",
           "type"=> "Language"
          ],
          [
           "name"=> "Idris",
           "type"=> "Language"
          ],
          [
           "name"=> "IMP",
           "type"=> "Language"
          ],
          [
           "name"=> "Inform",
           "type"=> "Language"
          ],
          [
           "name"=> "Io",
           "type"=> "Language"
          ],
          [
           "name"=> "Ioke",
           "type"=> "Language"
          ],
          [
           "name"=> "IPL",
           "type"=> "Language"
          ],
          [
           "name"=> "IPTSCRAE",
           "type"=> "Language"
          ],
          [
           "name"=> "ISLISP",
           "type"=> "Language"
          ],
          [
           "name"=> "ISPF",
           "type"=> "Language"
          ],
          [
           "name"=> "ISWIM",
           "type"=> "Language"
          ],
          [
           "name"=> "J",
           "type"=> "Language"
          ],
          [
           "name"=> "J#",
           "type"=> "Language"
          ],
          [
           "name"=> "J++",
           "type"=> "Language"
          ],
          [
           "name"=> "JADE",
           "type"=> "Language"
          ],
          [
           "name"=> "Jako",
           "type"=> "Language"
          ],
          [
           "name"=> "JAL",
           "type"=> "Language"
          ],
          [
           "name"=> "Janus",
           "type"=> "Language"
          ],
          [
           "name"=> "JASS",
           "type"=> "Language"
          ],
          [
           "name"=> "Java",
           "type"=> "Language"
          ],
          [
           "name"=> "JavaScript",
           "type"=> "Language"
          ],
          [
           "name"=> "JCL",
           "type"=> "Language"
          ],
          [
           "name"=> "JEAN",
           "type"=> "Language"
          ],
          [
           "name"=> "Join Java",
           "type"=> "Language"
          ],
          [
           "name"=> "JOSS",
           "type"=> "Language"
          ],
          [
           "name"=> "Joule",
           "type"=> "Language"
          ],
          [
           "name"=> "JOVIAL",
           "type"=> "Language"
          ],
          [
           "name"=> "Joy",
           "type"=> "Language"
          ],
          [
           "name"=> "JScript",
           "type"=> "Language"
          ],
          [
           "name"=> "JScript .NET",
           "type"=> "Language"
          ],
          [
           "name"=> "JavaFX Script",
           "type"=> "Language"
          ],
          [
           "name"=> "Julia",
           "type"=> "Language"
          ],
          [
           "name"=> "Jython",
           "type"=> "Language"
          ],
          [
           "name"=> "K",
           "type"=> "Language"
          ],
          [
           "name"=> "Kaleidoscope",
           "type"=> "Language"
          ],
          [
           "name"=> "Karel",
           "type"=> "Language"
          ],
          [
           "name"=> "Karel++",
           "type"=> "Language"
          ],
          [
           "name"=> "KEE",
           "type"=> "Language"
          ],
          [
           "name"=> "Kixtart",
           "type"=> "Language"
          ],
          [
           "name"=> "KIF",
           "type"=> "Language"
          ],
          [
           "name"=> "Kojo",
           "type"=> "Language"
          ],
          [
           "name"=> "Kotlin",
           "type"=> "Language"
          ],
          [
           "name"=> "KRC",
           "type"=> "Language"
          ],
          [
           "name"=> "KRL",
           "type"=> "Language"
          ],
          [
           "name"=> "KUKA",
           "type"=> "Language"
          ],
          [
           "name"=> "KRYPTON",
           "type"=> "Language"
          ],
          [
           "name"=> "L",
           "type"=> "Language"
          ],
          [
           "name"=> "L# .NET",
           "type"=> "Language"
          ],
          [
           "name"=> "LabVIEW",
           "type"=> "Language"
          ],
          [
           "name"=> "Ladder",
           "type"=> "Language"
          ],
          [
           "name"=> "Lagoona",
           "type"=> "Language"
          ],
          [
           "name"=> "LANSA",
           "type"=> "Language"
          ],
          [
           "name"=> "Lasso",
           "type"=> "Language"
          ],
          [
           "name"=> "LaTeX",
           "type"=> "Language"
          ],
          [
           "name"=> "Lava",
           "type"=> "Language"
          ],
          [
           "name"=> "LC-3",
           "type"=> "Language"
          ],
          [
           "name"=> "Leda",
           "type"=> "Language"
          ],
          [
           "name"=> "Legoscript",
           "type"=> "Language"
          ],
          [
           "name"=> "LIL",
           "type"=> "Language"
          ],
          [
           "name"=> "LilyPond",
           "type"=> "Language"
          ],
          [
           "name"=> "Limbo",
           "type"=> "Language"
          ],
          [
           "name"=> "Limnor",
           "type"=> "Language"
          ],
          [
           "name"=> "LINC",
           "type"=> "Language"
          ],
          [
           "name"=> "Lingo",
           "type"=> "Language"
          ],
          [
           "name"=> "Linoleum",
           "type"=> "Language"
          ],
          [
           "name"=> "LIS",
           "type"=> "Language"
          ],
          [
           "name"=> "LISA",
           "type"=> "Language"
          ],
          [
           "name"=> "Lisaac",
           "type"=> "Language"
          ],
          [
           "name"=> "Lisp",
           "type"=> "Language"
          ],
          [
           "name"=> "Lite-C",
           "type"=> "Language"
          ],
          [
           "name"=> "Lithe",
           "type"=> "Language"
          ],
          [
           "name"=> "Little b",
           "type"=> "Language"
          ],
          [
           "name"=> "Logo",
           "type"=> "Language"
          ],
          [
           "name"=> "Logtalk",
           "type"=> "Language"
          ],
          [
           "name"=> "LPC",
           "type"=> "Language"
          ],
          [
           "name"=> "LSE",
           "type"=> "Language"
          ],
          [
           "name"=> "LSL",
           "type"=> "Language"
          ],
          [
           "name"=> "LiveCode",
           "type"=> "Language"
          ],
          [
           "name"=> "LiveScript",
           "type"=> "Language"
          ],
          [
           "name"=> "Lua",
           "type"=> "Language"
          ],
          [
           "name"=> "Lucid",
           "type"=> "Language"
          ],
          [
           "name"=> "Lustre",
           "type"=> "Language"
          ],
          [
           "name"=> "LYaPAS",
           "type"=> "Language"
          ],
          [
           "name"=> "Lynx",
           "type"=> "Language"
          ],
          [
           "name"=> "M2001",
           "type"=> "Language"
          ],
          [
           "name"=> "M4",
           "type"=> "Language"
          ],
          [
           "name"=> "Machine code",
           "type"=> "Language"
          ],
          [
           "name"=> "MAD",
           "type"=> "Language"
          ],
          [
           "name"=> "MAD\/I",
           "type"=> "Language"
          ],
          [
           "name"=> "Magik",
           "type"=> "Language"
          ],
          [
           "name"=> "Magma",
           "type"=> "Language"
          ],
          [
           "name"=> "make",
           "type"=> "Language"
          ],
          [
           "name"=> "Maple",
           "type"=> "Language"
          ],
          [
           "name"=> "MAPPER",
           "type"=> "Language"
          ],
          [
           "name"=> "MARK-IV",
           "type"=> "Language"
          ],
          [
           "name"=> "Mary",
           "type"=> "Language"
          ],
          [
           "name"=> "MASM Microsoft Assembly x86",
           "type"=> "Language"
          ],
          [
           "name"=> "Mathematica",
           "type"=> "Language"
          ],
          [
           "name"=> "MATLAB",
           "type"=> "Language"
          ],
          [
           "name"=> "Maxima",
           "type"=> "Language"
          ],
          [
           "name"=> "Macsyma",
           "type"=> "Language"
          ],
          [
           "name"=> "Max",
           "type"=> "Language"
          ],
          [
           "name"=> "MaxScript",
           "type"=> "Language"
          ],
          [
           "name"=> "Maya (MEL)",
           "type"=> "Language"
          ],
          [
           "name"=> "MDL",
           "type"=> "Language"
          ],
          [
           "name"=> "Mercury",
           "type"=> "Language"
          ],
          [
           "name"=> "Mesa",
           "type"=> "Language"
          ],
          [
           "name"=> "Metacard",
           "type"=> "Language"
          ],
          [
           "name"=> "Metafont",
           "type"=> "Language"
          ],
          [
           "name"=> "MetaL",
           "type"=> "Language"
          ],
          [
           "name"=> "Microcode",
           "type"=> "Language"
          ],
          [
           "name"=> "MicroScript",
           "type"=> "Language"
          ],
          [
           "name"=> "MIIS",
           "type"=> "Language"
          ],
          [
           "name"=> "MillScript",
           "type"=> "Language"
          ],
          [
           "name"=> "MIMIC",
           "type"=> "Language"
          ],
          [
           "name"=> "Mirah",
           "type"=> "Language"
          ],
          [
           "name"=> "Miranda",
           "type"=> "Language"
          ],
          [
           "name"=> "MIVA Script",
           "type"=> "Language"
          ],
          [
           "name"=> "ML",
           "type"=> "Language"
          ],
          [
           "name"=> "Moby",
           "type"=> "Language"
          ],
          [
           "name"=> "Model 204",
           "type"=> "Language"
          ],
          [
           "name"=> "Modelica",
           "type"=> "Language"
          ],
          [
           "name"=> "Modula",
           "type"=> "Language"
          ],
          [
           "name"=> "Modula-2",
           "type"=> "Language"
          ],
          [
           "name"=> "Modula-3",
           "type"=> "Language"
          ],
          [
           "name"=> "Mohol",
           "type"=> "Language"
          ],
          [
           "name"=> "MOO",
           "type"=> "Language"
          ],
          [
           "name"=> "Mortran",
           "type"=> "Language"
          ],
          [
           "name"=> "Mouse",
           "type"=> "Language"
          ],
          [
           "name"=> "MPD",
           "type"=> "Language"
          ],
          [
           "name"=> "CIL",
           "type"=> "Language"
          ],
          [
           "name"=> "MSL",
           "type"=> "Language"
          ],
          [
           "name"=> "MUMPS",
           "type"=> "Language"
          ],
          [
           "name"=> "NASM",
           "type"=> "Language"
          ],
          [
           "name"=> "NATURAL",
           "type"=> "Language"
          ],
          [
           "name"=> "Napier88",
           "type"=> "Language"
          ],
          [
           "name"=> "Neko",
           "type"=> "Language"
          ],
          [
           "name"=> "Nemerle",
           "type"=> "Language"
          ],
          [
           "name"=> "nesC",
           "type"=> "Language"
          ],
          [
           "name"=> "NESL",
           "type"=> "Language"
          ],
          [
           "name"=> "Net.Data",
           "type"=> "Language"
          ],
          [
           "name"=> "NetLogo",
           "type"=> "Language"
          ],
          [
           "name"=> "NetRexx",
           "type"=> "Language"
          ],
          [
           "name"=> "NewLISP",
           "type"=> "Language"
          ],
          [
           "name"=> "NEWP",
           "type"=> "Language"
          ],
          [
           "name"=> "Newspeak",
           "type"=> "Language"
          ],
          [
           "name"=> "NewtonScript",
           "type"=> "Language"
          ],
          [
           "name"=> "NGL",
           "type"=> "Language"
          ],
          [
           "name"=> "Nial",
           "type"=> "Language"
          ],
          [
           "name"=> "Nice",
           "type"=> "Language"
          ],
          [
           "name"=> "Nickle",
           "type"=> "Language"
          ],
          [
           "name"=> "Nim",
           "type"=> "Language"
          ],
          [
           "name"=> "NPL",
           "type"=> "Language"
          ],
          [
           "name"=> "Not eXactly C",
           "type"=> "Language"
          ],
          [
           "name"=> "Not Quite C",
           "type"=> "Language"
          ],
          [
           "name"=> "NSIS",
           "type"=> "Language"
          ],
          [
           "name"=> "Nu",
           "type"=> "Language"
          ],
          [
           "name"=> "NWScript",
           "type"=> "Language"
          ],
          [
           "name"=> "NXT-G",
           "type"=> "Language"
          ],
          [
           "name"=> "o:XML",
           "type"=> "Language"
          ],
          [
           "name"=> "Oak",
           "type"=> "Language"
          ],
          [
           "name"=> "Oberon",
           "type"=> "Language"
          ],
          [
           "name"=> "Obix",
           "type"=> "Language"
          ],
          [
           "name"=> "OBJ2",
           "type"=> "Language"
          ],
          [
           "name"=> "Object Lisp",
           "type"=> "Language"
          ],
          [
           "name"=> "ObjectLOGO",
           "type"=> "Language"
          ],
          [
           "name"=> "Object REXX",
           "type"=> "Language"
          ],
          [
           "name"=> "Object Pascal",
           "type"=> "Language"
          ],
          [
           "name"=> "Objective-C",
           "type"=> "Language"
          ],
          [
           "name"=> "Objective-J",
           "type"=> "Language"
          ],
          [
           "name"=> "Obliq",
           "type"=> "Language"
          ],
          [
           "name"=> "Obol",
           "type"=> "Language"
          ],
          [
           "name"=> "OCaml",
           "type"=> "Language"
          ],
          [
           "name"=> "occam",
           "type"=> "Language"
          ],
          [
           "name"=> "occam-π",
           "type"=> "Language"
          ],
          [
           "name"=> "Octave",
           "type"=> "Language"
          ],
          [
           "name"=> "OmniMark",
           "type"=> "Language"
          ],
          [
           "name"=> "Onyx",
           "type"=> "Language"
          ],
          [
           "name"=> "Opa",
           "type"=> "Language"
          ],
          [
           "name"=> "Opal",
           "type"=> "Language"
          ],
          [
           "name"=> "OpenCL",
           "type"=> "Language"
          ],
          [
           "name"=> "OpenEdge ABL",
           "type"=> "Language"
          ],
          [
           "name"=> "OPL",
           "type"=> "Language"
          ],
          [
           "name"=> "OPS5",
           "type"=> "Language"
          ],
          [
           "name"=> "OptimJ",
           "type"=> "Language"
          ],
          [
           "name"=> "Orc",
           "type"=> "Language"
          ],
          [
           "name"=> "ORCA\/Modula-2",
           "type"=> "Language"
          ],
          [
           "name"=> "Oriel",
           "type"=> "Language"
          ],
          [
           "name"=> "Orwell",
           "type"=> "Language"
          ],
          [
           "name"=> "Oxygene",
           "type"=> "Language"
          ],
          [
           "name"=> "Oz",
           "type"=> "Language"
          ],
          [
           "name"=> "P#",
           "type"=> "Language"
          ],
          [
           "name"=> "ParaSail (programming language)",
           "type"=> "Language"
          ],
          [
           "name"=> "PARI\/GP",
           "type"=> "Language"
          ],
          [
           "name"=> "Pascal",
           "type"=> "Language"
          ],
          [
           "name"=> "Pawn",
           "type"=> "Language"
          ],
          [
           "name"=> "PCASTL",
           "type"=> "Language"
          ],
          [
           "name"=> "PCF",
           "type"=> "Language"
          ],
          [
           "name"=> "PEARL",
           "type"=> "Language"
          ],
          [
           "name"=> "PeopleCode",
           "type"=> "Language"
          ],
          [
           "name"=> "Perl",
           "type"=> "Language"
          ],
          [
           "name"=> "PDL",
           "type"=> "Language"
          ],
          [
           "name"=> "PHP",
           "type"=> "Language"
          ],
          [
           "name"=> "Phrogram",
           "type"=> "Language"
          ],
          [
           "name"=> "Pico",
           "type"=> "Language"
          ],
          [
           "name"=> "Picolisp",
           "type"=> "Language"
          ],
          [
           "name"=> "Pict",
           "type"=> "Language"
          ],
          [
           "name"=> "Pike",
           "type"=> "Language"
          ],
          [
           "name"=> "PIKT",
           "type"=> "Language"
          ],
          [
           "name"=> "PILOT",
           "type"=> "Language"
          ],
          [
           "name"=> "Pipelines",
           "type"=> "Language"
          ],
          [
           "name"=> "Pizza",
           "type"=> "Language"
          ],
          [
           "name"=> "PL-11",
           "type"=> "Language"
          ],
          [
           "name"=> "PL\/0",
           "type"=> "Language"
          ],
          [
           "name"=> "PL\/B",
           "type"=> "Language"
          ],
          [
           "name"=> "PL\/C",
           "type"=> "Language"
          ],
          [
           "name"=> "PL\/I",
           "type"=> "Language"
          ],
          [
           "name"=> "PL\/M",
           "type"=> "Language"
          ],
          [
           "name"=> "PL\/P",
           "type"=> "Language"
          ],
          [
           "name"=> "PL\/SQL",
           "type"=> "Language"
          ],
          [
           "name"=> "PL360",
           "type"=> "Language"
          ],
          [
           "name"=> "PLANC",
           "type"=> "Language"
          ],
          [
           "name"=> "Plankalkül",
           "type"=> "Language"
          ],
          [
           "name"=> "Planner",
           "type"=> "Language"
          ],
          [
           "name"=> "PLEX",
           "type"=> "Language"
          ],
          [
           "name"=> "PLEXIL",
           "type"=> "Language"
          ],
          [
           "name"=> "Plus",
           "type"=> "Language"
          ],
          [
           "name"=> "POP-11",
           "type"=> "Language"
          ],
          [
           "name"=> "PostScript",
           "type"=> "Language"
          ],
          [
           "name"=> "PortablE",
           "type"=> "Language"
          ],
          [
           "name"=> "Powerhouse",
           "type"=> "Language"
          ],
          [
           "name"=> "PowerBuilder",
           "type"=> "Language"
          ],
          [
           "name"=> "PowerShell",
           "type"=> "Language"
          ],
          [
           "name"=> "PPL",
           "type"=> "Language"
          ],
          [
           "name"=> "Processing",
           "type"=> "Language"
          ],
          [
           "name"=> "Processing.js",
           "type"=> "Language"
          ],
          [
           "name"=> "Prograph",
           "type"=> "Language"
          ],
          [
           "name"=> "PROIV",
           "type"=> "Language"
          ],
          [
           "name"=> "Prolog",
           "type"=> "Language"
          ],
          [
           "name"=> "PROMAL",
           "type"=> "Language"
          ],
          [
           "name"=> "Promela",
           "type"=> "Language"
          ],
          [
           "name"=> "PROSE modeling language",
           "type"=> "Language"
          ],
          [
           "name"=> "PROTEL",
           "type"=> "Language"
          ],
          [
           "name"=> "ProvideX",
           "type"=> "Language"
          ],
          [
           "name"=> "Pro*C",
           "type"=> "Language"
          ],
          [
           "name"=> "Pure",
           "type"=> "Language"
          ],
          [
           "name"=> "Python",
           "type"=> "Language"
          ],
          [
           "name"=> "Q (equational programming language)",
           "type"=> "Language"
          ],
          [
           "name"=> "Q (programming language from Kx Systems)",
           "type"=> "Language"
          ],
          [
           "name"=> "Qalb",
           "type"=> "Language"
          ],
          [
           "name"=> "QtScript",
           "type"=> "Language"
          ],
          [
           "name"=> "QuakeC",
           "type"=> "Language"
          ],
          [
           "name"=> "QPL",
           "type"=> "Language"
          ],
          [
           "name"=> "R",
           "type"=> "Language"
          ],
          [
           "name"=> "R++",
           "type"=> "Language"
          ],
          [
           "name"=> "Racket",
           "type"=> "Language"
          ],
          [
           "name"=> "RAPID",
           "type"=> "Language"
          ],
          [
           "name"=> "Rapira",
           "type"=> "Language"
          ],
          [
           "name"=> "Ratfiv",
           "type"=> "Language"
          ],
          [
           "name"=> "Ratfor",
           "type"=> "Language"
          ],
          [
           "name"=> "rc",
           "type"=> "Language"
          ],
          [
           "name"=> "REBOL",
           "type"=> "Language"
          ],
          [
           "name"=> "Red",
           "type"=> "Language"
          ],
          [
           "name"=> "Redcode",
           "type"=> "Language"
          ],
          [
           "name"=> "REFAL",
           "type"=> "Language"
          ],
          [
           "name"=> "Reia",
           "type"=> "Language"
          ],
          [
           "name"=> "Revolution",
           "type"=> "Language"
          ],
          [
           "name"=> "rex",
           "type"=> "Language"
          ],
          [
           "name"=> "REXX",
           "type"=> "Language"
          ],
          [
           "name"=> "Rlab",
           "type"=> "Language"
          ],
          [
           "name"=> "RobotC",
           "type"=> "Language"
          ],
          [
           "name"=> "ROOP",
           "type"=> "Language"
          ],
          [
           "name"=> "RPG",
           "type"=> "Language"
          ],
          [
           "name"=> "RPL",
           "type"=> "Language"
          ],
          [
           "name"=> "RSL",
           "type"=> "Language"
          ],
          [
           "name"=> "RTL\/2",
           "type"=> "Language"
          ],
          [
           "name"=> "Ruby",
           "type"=> "Language"
          ],
          [
           "name"=> "RuneScript",
           "type"=> "Language"
          ],
          [
           "name"=> "Rust",
           "type"=> "Language"
          ],
          [
           "name"=> "S",
           "type"=> "Language"
          ],
          [
           "name"=> "S2",
           "type"=> "Language"
          ],
          [
           "name"=> "S3",
           "type"=> "Language"
          ],
          [
           "name"=> "S-Lang",
           "type"=> "Language"
          ],
          [
           "name"=> "S-PLUS",
           "type"=> "Language"
          ],
          [
           "name"=> "SA-C",
           "type"=> "Language"
          ],
          [
           "name"=> "SabreTalk",
           "type"=> "Language"
          ],
          [
           "name"=> "SAIL",
           "type"=> "Language"
          ],
          [
           "name"=> "SALSA",
           "type"=> "Language"
          ],
          [
           "name"=> "SAM76",
           "type"=> "Language"
          ],
          [
           "name"=> "SAS",
           "type"=> "Language"
          ],
          [
           "name"=> "SASL",
           "type"=> "Language"
          ],
          [
           "name"=> "Sather",
           "type"=> "Language"
          ],
          [
           "name"=> "Sawzall",
           "type"=> "Language"
          ],
          [
           "name"=> "SBL",
           "type"=> "Language"
          ],
          [
           "name"=> "Scala",
           "type"=> "Language"
          ],
          [
           "name"=> "Scheme",
           "type"=> "Language"
          ],
          [
           "name"=> "Scilab",
           "type"=> "Language"
          ],
          [
           "name"=> "Scratch",
           "type"=> "Language"
          ],
          [
           "name"=> "Script.NET",
           "type"=> "Language"
          ],
          [
           "name"=> "Sed",
           "type"=> "Language"
          ],
          [
           "name"=> "Seed7",
           "type"=> "Language"
          ],
          [
           "name"=> "Self",
           "type"=> "Language"
          ],
          [
           "name"=> "SenseTalk",
           "type"=> "Language"
          ],
          [
           "name"=> "SequenceL",
           "type"=> "Language"
          ],
          [
           "name"=> "SETL",
           "type"=> "Language"
          ],
          [
           "name"=> "Shift Script",
           "type"=> "Language"
          ],
          [
           "name"=> "SIMPOL",
           "type"=> "Language"
          ],
          [
           "name"=> "SIGNAL",
           "type"=> "Language"
          ],
          [
           "name"=> "SiMPLE",
           "type"=> "Language"
          ],
          [
           "name"=> "SIMSCRIPT",
           "type"=> "Language"
          ],
          [
           "name"=> "Simula",
           "type"=> "Language"
          ],
          [
           "name"=> "Simulink",
           "type"=> "Language"
          ],
          [
           "name"=> "SISAL",
           "type"=> "Language"
          ],
          [
           "name"=> "SLIP",
           "type"=> "Language"
          ],
          [
           "name"=> "SMALL",
           "type"=> "Language"
          ],
          [
           "name"=> "Smalltalk",
           "type"=> "Language"
          ],
          [
           "name"=> "Small Basic",
           "type"=> "Language"
          ],
          [
           "name"=> "SML",
           "type"=> "Language"
          ],
          [
           "name"=> "Snap!",
           "type"=> "Language"
          ],
          [
           "name"=> "SNOBOL",
           "type"=> "Language"
          ],
          [
           "name"=> "SPITBOL",
           "type"=> "Language"
          ],
          [
           "name"=> "Snowball",
           "type"=> "Language"
          ],
          [
           "name"=> "SOL",
           "type"=> "Language"
          ],
          [
           "name"=> "Span",
           "type"=> "Language"
          ],
          [
           "name"=> "SPARK",
           "type"=> "Language"
          ],
          [
           "name"=> "Speedcode",
           "type"=> "Language"
          ],
          [
           "name"=> "SPIN",
           "type"=> "Language"
          ],
          [
           "name"=> "SP\/k",
           "type"=> "Language"
          ],
          [
           "name"=> "SPS",
           "type"=> "Language"
          ],
          [
           "name"=> "Squeak",
           "type"=> "Language"
          ],
          [
           "name"=> "Squirrel",
           "type"=> "Language"
          ],
          [
           "name"=> "SR",
           "type"=> "Language"
          ],
          [
           "name"=> "S\/SL",
           "type"=> "Language"
          ],
          [
           "name"=> "Stackless Python",
           "type"=> "Language"
          ],
          [
           "name"=> "Starlogo",
           "type"=> "Language"
          ],
          [
           "name"=> "Strand",
           "type"=> "Language"
          ],
          [
           "name"=> "Stata",
           "type"=> "Language"
          ],
          [
           "name"=> "Stateflow",
           "type"=> "Language"
          ],
          [
           "name"=> "Subtext",
           "type"=> "Language"
          ],
          [
           "name"=> "SuperCollider",
           "type"=> "Language"
          ],
          [
           "name"=> "SuperTalk",
           "type"=> "Language"
          ],
          [
           "name"=> "Swift (Apple programming language)",
           "type"=> "Language"
          ],
          [
           "name"=> "Swift (parallel scripting language)",
           "type"=> "Language"
          ],
          [
           "name"=> "SYMPL",
           "type"=> "Language"
          ],
          [
           "name"=> "SyncCharts",
           "type"=> "Language"
          ],
          [
           "name"=> "SystemVerilog",
           "type"=> "Language"
          ],
          [
           "name"=> "T",
           "type"=> "Language"
          ],
          [
           "name"=> "TACL",
           "type"=> "Language"
          ],
          [
           "name"=> "TACPOL",
           "type"=> "Language"
          ],
          [
           "name"=> "TADS",
           "type"=> "Language"
          ],
          [
           "name"=> "TAL",
           "type"=> "Language"
          ],
          [
           "name"=> "Tcl",
           "type"=> "Language"
          ],
          [
           "name"=> "Tea",
           "type"=> "Language"
          ],
          [
           "name"=> "TECO",
           "type"=> "Language"
          ],
          [
           "name"=> "TELCOMP",
           "type"=> "Language"
          ],
          [
           "name"=> "TeX",
           "type"=> "Language"
          ],
          [
           "name"=> "TEX",
           "type"=> "Language"
          ],
          [
           "name"=> "TIE",
           "type"=> "Language"
          ],
          [
           "name"=> "Timber",
           "type"=> "Language"
          ],
          [
           "name"=> "TMG",
           "type"=> "Language"
          ],
          [
           "name"=> "Tom",
           "type"=> "Language"
          ],
          [
           "name"=> "TOM",
           "type"=> "Language"
          ],
          [
           "name"=> "Topspeed",
           "type"=> "Language"
          ],
          [
           "name"=> "TPU",
           "type"=> "Language"
          ],
          [
           "name"=> "Trac",
           "type"=> "Language"
          ],
          [
           "name"=> "TTM",
           "type"=> "Language"
          ],
          [
           "name"=> "T-SQL",
           "type"=> "Language"
          ],
          [
           "name"=> "TTCN",
           "type"=> "Language"
          ],
          [
           "name"=> "Turing",
           "type"=> "Language"
          ],
          [
           "name"=> "TUTOR",
           "type"=> "Language"
          ],
          [
           "name"=> "TXL",
           "type"=> "Language"
          ],
          [
           "name"=> "TypeScript",
           "type"=> "Language"
          ],
          [
           "name"=> "Turbo C++",
           "type"=> "Language"
          ],
          [
           "name"=> "Ubercode",
           "type"=> "Language"
          ],
          [
           "name"=> "UCSD Pascal",
           "type"=> "Language"
          ],
          [
           "name"=> "Umple",
           "type"=> "Language"
          ],
          [
           "name"=> "Unicon",
           "type"=> "Language"
          ],
          [
           "name"=> "Uniface",
           "type"=> "Language"
          ],
          [
           "name"=> "UNITY",
           "type"=> "Language"
          ],
          [
           "name"=> "Unix shell",
           "type"=> "Language"
          ],
          [
           "name"=> "UnrealScript",
           "type"=> "Language"
          ],
          [
           "name"=> "Vala",
           "type"=> "Language"
          ],
          [
           "name"=> "VBA",
           "type"=> "Language"
          ],
          [
           "name"=> "VBScript",
           "type"=> "Language"
          ],
          [
           "name"=> "Verilog",
           "type"=> "Language"
          ],
          [
           "name"=> "VHDL",
           "type"=> "Language"
          ],
          [
           "name"=> "Visual Basic",
           "type"=> "Language"
          ],
          [
           "name"=> "Visual Basic .NET",
           "type"=> "Language"
          ],
          [
           "name"=> "Visual DataFlex",
           "type"=> "Language"
          ],
          [
           "name"=> "Visual DialogScript",
           "type"=> "Language"
          ],
          [
           "name"=> "Visual Fortran",
           "type"=> "Language"
          ],
          [
           "name"=> "Visual FoxPro",
           "type"=> "Language"
          ],
          [
           "name"=> "Visual J++",
           "type"=> "Language"
          ],
          [
           "name"=> "Visual J#",
           "type"=> "Language"
          ],
          [
           "name"=> "Visual Objects",
           "type"=> "Language"
          ],
          [
           "name"=> "Visual Prolog",
           "type"=> "Language"
          ],
          [
           "name"=> "VSXu",
           "type"=> "Language"
          ],
          [
           "name"=> "Vvvv",
           "type"=> "Language"
          ],
          [
           "name"=> "WATFIV, WATFOR",
           "type"=> "Language"
          ],
          [
           "name"=> "WebDNA",
           "type"=> "Language"
          ],
          [
           "name"=> "WebQL",
           "type"=> "Language"
          ],
          [
           "name"=> "Windows PowerShell",
           "type"=> "Language"
          ],
          [
           "name"=> "Winbatch",
           "type"=> "Language"
          ],
          [
           "name"=> "Wolfram",
           "type"=> "Language"
          ],
          [
           "name"=> "Wyvern",
           "type"=> "Language"
          ],
          [
           "name"=> "X++",
           "type"=> "Language"
          ],
          [
           "name"=> "X#",
           "type"=> "Language"
          ],
          [
           "name"=> "X10",
           "type"=> "Language"
          ],
          [
           "name"=> "XBL",
           "type"=> "Language"
          ],
          [
           "name"=> "XC",
           "type"=> "Language"
          ],
          [
           "name"=> "XMOS architecture",
           "type"=> "Language"
          ],
          [
           "name"=> "xHarbour",
           "type"=> "Language"
          ],
          [
           "name"=> "XL",
           "type"=> "Language"
          ],
          [
           "name"=> "Xojo",
           "type"=> "Language"
          ],
          [
           "name"=> "XOTcl",
           "type"=> "Language"
          ],
          [
           "name"=> "XPL",
           "type"=> "Language"
          ],
          [
           "name"=> "XPL0",
           "type"=> "Language"
          ],
          [
           "name"=> "XQuery",
           "type"=> "Language"
          ],
          [
           "name"=> "XSB",
           "type"=> "Language"
          ],
          [
           "name"=> "XSLT",
           "type"=> "Language"
          ],
          [
           "name"=> "XPath",
           "type"=> "Language"
          ],
          [
           "name"=> "Xtend",
           "type"=> "Language"
          ],
          [
           "name"=> "Yorick",
           "type"=> "Language"
          ],
          [
           "name"=> "YQL",
           "type"=> "Language"
          ],
          [
           "name"=> "Z notation",
           "type"=> "Language"
          ],
          [
           "name"=> "Zeno",
           "type"=> "Language"
          ],
          [
           "name"=> "ZOPL",
           "type"=> "Language"
          ],
          [
           "name"=> "ZPL",
           "type"=> "Language"
          ],
          [
           "name"=> "Django",
           "type"=> "Framework"
          ],
          [
           "name"=> "Ruby on Rails",
           "type"=> "Framework"
          ],
          [
           "name"=> "Spring Boot",
           "type"=> "Framework"
          ],
          [
           "name"=> "Laravel",
           "type"=> "Framework"
          ],
          [
           "name"=> "Angular",
           "type"=> "Framework"
          ],
          [
           "name"=> "React",
           "type"=> "Framework"
          ],
          [
           "name"=> "Vue",
           "type"=> "Framework"
          ],
          [
           "name"=> "Svelte",
           "type"=> "Framework"
          ]
         ];

        ProgrammingLanguage::insert($programming_languages);
    }
}
