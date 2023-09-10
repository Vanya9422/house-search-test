<?php

namespace App\Facades;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Helpers
{
	const DATE_FORMAT = 'Y-m-d';
	const TIME_DATE_FORMAT = 'Y-m-d H:i:s';
	const PAGINATION_COUNT = 20;

	/**
	 * @param string $folder
	 * @return void
	 */
	static function findFiles(string $folder)
	{
		$files = scandir($folder);

		foreach ($files as $file) {
			// Игнорируем текущую и родительскую директории
			if ($file != '.' && $file != '..') {
				$path = $folder . '/' . $file;
				if (is_file($path)) {
					include_once $path;
				} elseif (is_dir($path)) {
					// Если это директория, вызываем функцию рекурсивно
					static::findFiles($path);
				}
			}
		}
	}

	/**
	 * @param $model_name
	 * @return bool|string
	 */
	static function generate_dir_from_model_name($model_name): bool|string
	{
		$dirPaths = explode('\\', $model_name);

		return end($dirPaths);
	}

	/**
	 * @param string $date
	 * @return string
	 */
	static function to_time_format(string $date): string
	{
		return Carbon::parse($date)->format(static::DATE_FORMAT);
	}

	/**
	 * @param array $data
	 * @return bool
	 */
	static function existsUploadAbleFileInArray(array $data): bool
	{
		foreach ($data as $item) {

			if (is_array($item)) {
				foreach ($item as $value) {
					if ($value instanceof UploadedFile) return true;
				}
			} else {
				if ($item instanceof UploadedFile) return true;
			}
		}

		return false;
	}

	/**
	 * @param $builder
	 * @return string
	 */
	static function getQueries($builder): string
	{
		$addSlashes = str_replace('?', "'?'", $builder->toSql());

		return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
	}

	/**
	 * @param $relation
	 * @param array $data
	 * @param string $field
	 * @param string $method
	 */
	static function eloquentRelationMake($relation, array $data, string $field, string $method): void
	{
		if (isset($data[$field])) {
			$relation->{$field}()->{$method}($data[$field]);
		}
	}

	/**
	 * @param array $array
	 * @param array $except
	 * @return array
	 */
	static function deleteValue(array $array, array $except): array
	{
		return collect($array)->reject(function ($item) use ($except) {
			return in_array($item, $except);
		})->toArray();
	}

	/**
	 * @param $start
	 * @return string
	 */
	static function diff_seconds_echo($start): string
	{
		return ' Seconds to execute: ' . (microtime(TRUE) - $start) * 1000;
	}

	/**
	 * @param string $name
	 * @param array $array
	 * @return void
	 */
	static function unset_value(string $name, array &$array): void
	{
		if (($key = array_search($name, $array)) !== false) {
			unset($array[$key]);
		}
	}

	/**
	 * @param string|null $guardName
	 * @return User|null
	 */
	static function user(?string $guardName = null): User|null
	{
		static $staticUser;

		if (!$guardName) $guardName = config('auth.defaults.guard');

		if (!$staticUser) $staticUser = auth($guardName)->user() ?? auth()->user();

		return $staticUser;
	}

	/**
	 * $permission 'string' or ['string', 'string']
	 * Used Package Spatie Permissions https://spatie.be/docs/laravel-permission/v5/introduction
	 * @param User $user
	 * @param string|array $permission
	 */
	static function setPermissionIfNoExists(User $user, string|array $permission): void
	{
		if (!$user->hasPermissionTo($permission)) {
			$user->givePermissionTo($permission);
		}
	}

	/**
	 * @return bool
	 */
	static function isLocal(): bool
	{
		static $isLocal;

		if (!$isLocal) $isLocal = app()->environment('local');

		return $isLocal;
	}

	/**
	 * @param Model $model
	 * @param UploadedFile $file
	 * @param string|null $collectionName
	 * @param string $disk
	 */
	static public function upload(
		Model $model,
		UploadedFile $file,
		string $collectionName = null,
		string $disk = Media::DEFAULT_DISC
	): void {
		/** @var HasMedia $model */
		try {
			$model->addMedia($file)->toMediaCollection($collectionName ?: get_class($model), $disk);
		} catch (FileDoesNotExist|FileIsTooBig $e) {
			Log::error($e->getMessage());
		}
	}

	/**
	 * @param Model $model
	 * @param Model $relation
	 * @return void
	 */
	static function associateRelation(Model $model, Model $relation): void {
		try {
			$relationName = strtolower(\Helpers::generate_dir_from_model_name($relation->getMorphClass()));

			$model->{$relationName}()->associate($relation)->save();
		} catch (\Exception $e) {
			\Log::error($e);
		}
	}

	/**
	 * @return bool
	 */
	static function isManagement(): bool
	{
		if (!static::user()) return false;

		return static::user()->isAdmin() || static::user()->isSuperAdmin() || static::user()->isModerator();
	}
}
