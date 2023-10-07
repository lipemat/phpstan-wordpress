<?php

namespace Composer\Script {
	class Event {
		public function getComposer() {
			return new \Composer\Composer();
		}

		public function getIO() {
			return new \Composer\IO\NullIO();
		}
	}
}
