# rest-test-app

## Advert testing:

**parameters:**
  - env [PROD|QA]
  - region [UK|EU|MEA|NA|LA|AP]

*phpunit --bootstrap=vendor/autoload.php tests/Advert.php env=PROD region=UK*

## Manifest testing:

**parameters:**
  - env [PROD|QA]
  - region [EU|AP|US]

*phpunit --bootstrap=vendor/autoload.php tests/Manifest.php env=PROD region=AP*

## Bundle testing:**

**parameters:**
  - env [PROD|QA]
  - region [EU|AP|US]
  - date YYYY-MM-DD

*phpunit --bootstrap=vendor/autoload.php Tests/Manifest.php env=PROD region=AP date=2017-05-10*
