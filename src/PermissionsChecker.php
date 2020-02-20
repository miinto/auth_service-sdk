<?php

declare(strict_types=1);

namespace Miinto\AuthService\Sdk;

class PermissionsChecker
{
    /** @var array */
    protected $privileges = [];

    /**
     * PermissionsChecker constructor.
     *
     * @param array $privileges
     */
    public function __construct(array $privileges = [])
    {
        $this->privileges = [];
    }

    /**
     * @param string $systemName
     * @param string $elementType
     * @param string $elementId
     * @param string $component
     * @param int $flag
     *
     * @return bool
     */
    public function check(
        string $systemName = '*',
        string $elementType = '*',
        string $elementId = '*',
        string $component = '*',
        int $flag = -1
    ): bool {
        // Get match flag for entity
        $privilege = $this->getPrivFlag($systemName, $elementType, $elementId, $component);
        // check privilege flags

        if (\is_null($privilege)) {
            return false;
        } // no privileges for the specified resource

        if ($flag === -1 && $privilege !== -1) {
            return false;
        } // requested all privileges but only specific privileges exist

        if ($flag < -1) {
            return false;
        } // incorrect flag specified

        if ($privilege === -1) {
            return true;
        } // global privileges flag matched

        return (bool)($flag & $privilege);
    }


    /**
     * Fetch the privilege flag for specified privilege path.
     *
     * @param string $systemName
     * @param string $elementType
     * @param string $elementId
     * @param string $component
     *
     * @return int|null
     */
    private function getPrivFlag(string $systemName, string $elementType, string $elementId, string $component): ?int
    {
        /** SYSTEM NAME level */
        // handle wildcard on $systemName
        if (\array_key_exists('*', $this->getPrivileges())) {
            return $this->getPrivileges()['*'];
        }
        // handle nonexistent $systemName
        if (!\array_key_exists($systemName, $this->getPrivileges())) {
            return null;
        }
        /** ELEMENT TYPE level */
        // handle wildcard on $elementType
        if (\array_key_exists('*', $this->getPrivileges()[$systemName])) {
            return $this->getPrivileges()[$systemName]['*'];
        }
        // handle nonexistent $elementType
        if (!\array_key_exists($elementType, $this->getPrivileges()[$systemName])) {
            return null;
        }
        /** ELEMENT ID level */
        // handle wildcard on $elementId
        if (\array_key_exists('*', $this->getPrivileges()[$systemName][$elementType])) {
            return $this->getPrivileges()[$systemName][$elementType]['*'];
        }
        // handle nonexistent $elementId
        if (!\array_key_exists($elementId, $this->getPrivileges()[$systemName][$elementType])) {
            return null;
        }
        /** COMPONENT level */
        // handle wildcard on $component
        if (\array_key_exists('*', $this->getPrivileges()[$systemName][$elementType][$elementId])) {
            return $this->getPrivileges()[$systemName][$elementType][$elementId]['*'];
        }
        // handle nonexistent $component
        if (!\array_key_exists($component, $this->getPrivileges()[$systemName][$elementType][$elementId])) {
            return null;
        }
        return $this->getPrivileges()[$systemName][$elementType][$elementId][$component];
    }

    /**
     * Fetch current privilege set.
     *
     * @return array
     */
    public function getPrivileges(): array
    {
        return $this->privileges;
    }

    /**
     * @param array $privileges
     *
     * @return $this
     */
    public function setPrivileges(array $privileges = []): self
    {
        $this->privileges = $privileges;

        return $this;
    }

}