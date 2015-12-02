<?php namespace KlinkDMS\Traits;


use Illuminate\Support\Facades\Config;
use Symfony\Component\Process\Exception\InvalidArgumentException;
use KlinkDMS\Capability;

/**
 * Add support for checking capabilities and permission to the User Eloquent Model
 */
trait HasCapability
{

    // User relations ---------------------------------------------------------
    
    private $dirtyCapabilities = false;

    /**
     * Retrive the associated Capabilities
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function capabilities()
    {
        return $this->belongsToMany('KlinkDMS\Capability', 'capability_user')->withTimestamps();
    }


    // Testing capabilities ---------------------------------------------------
    
    /**
     * Check if user has a permission by its name.
     *
     * @param string|array $permission Capability name or array of Capability names
     * @return boolean return true if the user supports at least one of the specified $permission
     */
    public function can($permission)
    {

        if(empty($permission)){
            return false;
        }

        $caps = $this->dirtyCapabilities ? $this->fresh()->capabilities->toArray() : $this->capabilities->toArray();

        if(empty($caps)){
            return false;
        }

        $names = array_fetch($caps, 'key');

        if(empty($names)){
            return false;
        }

        if(is_array( $permission )){

            $diff = array_diff($permission, $names);
            $perms_count = count($permission);
            $diff_count = count($diff);

            $intersect = array_intersect($permission, $names);

            return !empty($intersect);

            
        }

        return in_array($permission, $names);

    }

    /**
     * Verify if all the specified capabilities are met by the user
     * 
     * @param string[] $capabilities the array of Capability names to check for
     * @return boolean true if the the $capabilities are met by the user
     */
    public function canAll(array $capabilities)
    {

        if(empty($capabilities)){
            return false;
        }

        $caps = $this->dirtyCapabilities ? $this->fresh()->capabilities->toArray() : $this->capabilities->toArray();

        if(empty($caps)){
            return false;
        }

        $names = array_fetch($caps, 'key');

        $intersect = array_intersect($capabilities, $names);

        return $intersect == $capabilities;

    }

    /**
     * Check if the user can manage content.
     * 
     * Test if the user has all the @see \KlinkDMS\Capability::$CONTENT_MANAGER capabilities
     * 
     * @return boolean true if is a content manager, false otherwise
     */
    public function isContentManager()
    {
        return $this->canAll(Capability::$CONTENT_MANAGER);
    }

    /**
     * Check if the user has full administrative powers
     * 
     * Test if the user has all the @see \KlinkDMS\Capability::$ADMIN capabilities
     * 
     * @return boolean true if is a DMS administrator, false otherwise
     */
    public function isDMSAdmin()
    {
        return $this->canAll(Capability::$ADMIN);
    }

    /**
     * Check if the user can perform DMS Management operations
     * 
     * Test if the user has all the @see \KlinkDMS\Capability::$DMS_MASTER capabilities
     * 
     * @return boolean true if can manage the DMS configuration, false otherwise
     */
    public function isDMSManager()
    {
        return $this->canAll(Capability::$DMS_MASTER);
    }


    // Adding and removing capabilities ---------------------------------------


    public function addCapability( $cap )
    {

        if( is_string($cap) ){
            $cap = Capability::fromKey($cap)->first();
        }


        if( is_object($cap)){
            $cap = $cap->getKey();
        }
        if( is_array($cap)){
            $cap = $cap['id'];
        }
        
        $this->dirtyCapabilities = true;
        
        return $this->capabilities()->attach( $cap );
    }

    /**
     * Adds multiple capabilities to the user
     * @param array $caps array of capability names or capability ids
     */
    public function addCapabilities(array $capabilities )
    {

        $cap_instances = array_map(function($el){
            
            if(is_int($el)){
                return Capability::findOrFail($el);
            }
            else if(is_string($el)){
                return Capability::fromKey($el)->first();
            }
            else if($el instanceof Capability){
                return $el;
            }
            else {
                throw new \Exception('Unkwnown capability');
            }
            
        }, $capabilities);

        $that = $this;
        
        return \DB::transaction(function() use($that, $cap_instances){
            
            $count = 1;
            
            foreach($cap_instances as $cap){
                $that->addCapability($cap);
                $count = $count+1;
            }
            
            $that->dirtyCapabilities = true;
            
            return $count;
        });

    }


    public function removeCapability( $cap )
    {
        if (is_object($cap)) {
            $cap = $cap->getKey();
        }
        if (is_array($cap)) {
            $cap = $cap['id'];
        }
        
        if( is_string($cap) ){
            $cap = Capability::fromKey($cap)->first();
        }
        
        $this->dirtyCapabilities = true;
        
        return $this->capabilities()->detach($cap);
    }

}