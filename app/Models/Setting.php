<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value.
     */
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get all payment settings as array.
     */
    public static function getPaymentSettings(): array
    {
        return [
            'bank1_nama' => static::get('bank1_nama', 'Bank BCA'),
            'bank1_norek' => static::get('bank1_norek', '123-456-7890'),
            'bank1_atas_nama' => static::get('bank1_atas_nama', 'Yayasan Bumi Damai'),
            'bank2_nama' => static::get('bank2_nama', 'Bank Mandiri'),
            'bank2_norek' => static::get('bank2_norek', '098-765-4321'),
            'bank2_atas_nama' => static::get('bank2_atas_nama', 'Yayasan Bumi Damai'),
            'qris_image' => static::get('qris_image', 'images/qris-code.jpeg'),
            'qris_atas_nama' => static::get('qris_atas_nama', 'Yayasan Bumi Damai'),
        ];
    }

    /**
     * Get site settings (logo, hero, WA, etc).
     */
    public static function getSiteSettings(): array
    {
        return [
            'site_name' => static::get('site_name', 'Bumi Damai'),
            'site_logo' => static::get('site_logo', ''),
            'hero_title' => static::get('hero_title', 'Berbagi Kebahagiaan untuk Anak-Anak Panti'),
            'hero_subtitle' => static::get('hero_subtitle', 'Mari bergabung bersama kami dalam misi mulia membantu anak-anak yatim piatu dan dhuafa mendapatkan pendidikan dan kehidupan yang lebih baik.'),
            'hero_badge' => static::get('hero_badge', 'Yayasan Sosial Kemanusiaan'),
            'hero_image' => static::get('hero_image', ''),
            'wa_konfirmasi' => static::get('wa_konfirmasi', '6281234567890'),
        ];
    }

    /**
     * Get yayasan profile settings.
     */
    public static function getProfileSettings(): array
    {
        return [
            'profil_nama' => static::get('profil_nama', 'Yayasan Bumi Damai'),
            'profil_deskripsi1' => static::get('profil_deskripsi1', 'Yayasan Bumi Damai adalah lembaga sosial yang berdedikasi untuk memberikan perlindungan, pendidikan, dan kasih sayang kepada anak-anak yatim, piatu, dan dhuafa. Kami berkomitmen untuk menciptakan lingkungan yang aman dan penuh cinta bagi setiap anak asuh kami.'),
            'profil_deskripsi2' => static::get('profil_deskripsi2', 'Dengan dukungan para donatur dan relawan, kami telah menjalankan berbagai program pemberdayaan mulai dari pendidikan formal, pelatihan keterampilan, hingga kegiatan sosial yang membangun karakter anak-anak menjadi generasi yang mandiri dan berakhlak mulia.'),
            'profil_visi' => static::get('profil_visi', 'Menjadi lembaga sosial terpercaya yang mampu mencetak generasi muda yang mandiri, berpendidikan, dan berakhlak mulia melalui program pembinaan yang berkelanjutan.'),
            'profil_misi' => static::get('profil_misi', 'Memberikan pendidikan berkualitas, pendampingan spiritual, pelatihan keterampilan hidup, serta menciptakan lingkungan yang kondusif bagi tumbuh kembang anak asuh.'),
            'profil_nilai' => static::get('profil_nilai', 'Kejujuran, transparansi, dan keikhlasan adalah pondasi kami dalam melayani. Setiap donasi yang masuk akan dikelola secara amanah untuk kesejahteraan anak-anak asuh.'),
        ];
    }
}
