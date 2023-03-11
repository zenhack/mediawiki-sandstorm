@0xb2b626bd4d31c1ba;

using Spk = import "/sandstorm/package.capnp";
# This imports:
#   $SANDSTORM_HOME/latest/usr/include/sandstorm/package.capnp
# Check out that file to see the full, documented package definition format.

const pkgdef :Spk.PackageDefinition = (
  # The package definition. Note that the spk tool looks specifically for the
  # "pkgdef" constant.

  id = "p04q48xd2kgkystkrda5n77kdns6u569wnactgh904tf7s3vev70",
  # Your app ID is actually its public key. The private key was placed in
  # your keyring. All updates must be signed with the same key.

  manifest = (
    # This manifest is included in your app package to tell Sandstorm
    # about your app.

    appTitle = (defaultText = "MediaWiki"),

    appVersion = 3,  # Increment this for every release.

    appMarketingVersion = (defaultText = embed "version.txt"),

    actions = [
      # Define your "new document" handlers ere.
      ( title = (defaultText = "New MediaWiki"),
        nounPhrase = (defaultText = "wiki"),
        command = .myCommand
        # The command to run when starting for the first time. (".myCommand"
        # is just a constant defined at the bottom of the file.)
      )
    ],

    continueCommand = .myCommand,

    metadata = (
      icons = (
        appGrid = .mediawikiLogo,
        grain = .mediawikiLogo,
        market = .mediawikiLogo,
      ),

      website = "https://www.mediawiki.org",
      codeUrl = "https://github.com/zenhack/mediawiki-sandstorm",
      license = (openSource = gpl2),
      categories = [productivity],

      author = (
        contactEmail = "ian@zenhack.net",
        pgpSignature = embed "pgp-signature",
        upstreamAuthor = "MediaWiki Contributors",
      ),
      pgpKeyring = embed "pgp-keyring",

      description = (defaultText = embed "description.md"),
      shortDescription = (defaultText = "Wiki"),

      changeLog = (defaultText = embed "../mediawiki/HISTORY"),

      screenshots = [
        (width = 448, height = 351, png = embed "sandstorm-screenshot.png")
      ],
    ),
  ),

  sourceMap = (
    # Here we defined where to look for files to copy into your package. The
    # `spk dev` command actually figures out what files your app needs
    # automatically by running it on a FUSE filesystem. So, the mappings
    # here are only to tell it where to find files that the app wants.
    searchPath = [
      (
        packagePath = "opt/app/mediawiki/LocalSettings.php",
        sourcePath = "/opt/app/LocalSettings.php",
      ),
      (
        packagePath = "opt/app/mediawiki/extensions/SandstormAuth",
        sourcePath = "/opt/app/SandstormAuth-extension",
      ),
      ( sourcePath = "." ),  # Search this directory first.
      ( sourcePath = "/",    # Then search the system root directory.
        hidePaths = [
        # You probably don't want the app pulling files from these places,
        # so we hide them. Note that /dev, /var, and /tmp are implicitly
        # hidden because Sandstorm itself provides them.
        "home", "proc", "sys",
        "etc/passwd", "etc/hosts", "etc/host.conf",
        "etc/nsswitch.conf", "etc/resolv.conf",

        # Mediawiki's history is quite large; avoid pulling it in.
        "opt/app/mediawiki/.git",
        ]
      )
    ]
  ),

  fileList = "sandstorm-files.list",
  # `spk dev` will write a list of all the files your app uses to this file.
  # You should review it later, before shipping your app.

  alwaysInclude = [
    # Fill this list with more names of files or directories that should be
    # included in your package, even if not listed in sandstorm-files.list.
    # Use this to force-include stuff that you know you need but which may
    # not have been detected as a dependency during `spk dev`. If you list
    # a directory here, its entire contents will be included recursively.
    "opt/app",
    "usr/bin/convert",
    "usr/bin/diff3",
  ],

  bridgeConfig = (
    viewInfo = (
      permissions = [
          # N.B. the way the auth plugin works, the permission names
          # should each match a group defined in $wgGroupPermissions
          # in LocalSettings.php.
          (name = "sysop"),
        ],
      roles = [(title = (defaultText = "admin"),
                permissions = [true],
                verbPhrase = (defaultText = "can administer wiki")),
               (title = (defaultText = "editor"),
                permissions = [false],
                verbPhrase = (defaultText = "can view or edit any article"),
                default = true)],
    )
  ),
);

const mediawikiLogo :Spk.Metadata.Icon = (svg = ( embed "app-graphics/mediawiki.svg"));

const myCommand :Spk.Manifest.Command = (
  # Here we define the command used to start up your server.
  argv = ["/sandstorm-http-bridge", "8000", "--", "/opt/app/.sandstorm/launcher.sh"],
  environ = [
    # Note that this defines the *entire* environment seen by your app.
    (key = "PATH", value = "/usr/local/bin:/usr/bin:/bin"),
    (key = "HOME", value = "/var")
  ]
);
