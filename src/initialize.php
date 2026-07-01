<?php
namespace Pyncer\Snyppet\Contact;

use Pyncer\Initializer;

Initializer::defineFrom('Pyncer\Snyppet\Contact\PHONE_ALLOW_E164', 'Pyncer\Validation\PHONE_ALLOW_E164', true);
Initializer::defineFrom('Pyncer\Snyppet\Contact\PHONE_ALLOW_NANP', 'Pyncer\Validation\PHONE_ALLOW_NANP', false);
Initializer::defineFrom('Pyncer\Snyppet\Contact\PHONE_ALLOW_FORMATTING', 'Pyncer\Validation\PHONE_ALLOW_FORMATTING', false);
