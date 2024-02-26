<?php

use Illuminate\Database\Seeder;
use App\Models\Widyaiswara;

class WidyaiswaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        	["name" => "BAMBANG SIGIT PRAMONO, S.SOS, MSI", "position" => "Widyaiswara Ahli Madya", "about" => "-", "photo" => "http://sijawara.diskopukm.jatimprov.go.id/uploads/widyaiswaras/team-member-23.jpg"],
					["name" => "RATNA SAKTIJANINGDIJAH, SE, MSA", "position" => "Widyaiswara Ahli Madya", "about" => "Widyaiswara Ahli Madya", "photo" => "http://sijawara.diskopukm.jatimprov.go.id/uploads/widyaiswaras/team-member-22.jpg"],
					["name" => "DRS. MARIS ABD. MULUK M.SI", "position" => "Widyaiswara Ahli Madya", "about" => "-", "photo" => "http://sijawara.diskopukm.jatimprov.go.id/uploads/widyaiswaras/team-member-15.jpg"],
					["name" => "ELOK NING FAIKOH Spi, M.P.", "position" => "Widyaiswara Muda", "about" => "Elok Ning Faikoh adalah widyaiswara muda yang sangat handal dalam bidangnya", "photo" => "http://sijawara.diskopukm.jatimprov.go.id/uploads/widyaiswaras/team-member-11.jpg"],
					["name" => "HOTMA SILALAHI S.T., M.T", "position" => "Widyaiswara", "about" => "-", "photo" => "http://sijawara.diskopukm.jatimprov.go.id/uploads/widyaiswaras/team-member-17.jpg"],
					["name" => "MARIO DWI PUTRA LESMANA, S.S, M.PD", "position" => "Widyaiswara Ahli Pertama", "about" => "Ahli pertama yang ada di dunia", "photo" => "http://sijawara.diskopukm.jatimprov.go.id/uploads/widyaiswaras/team-member-14.jpg"],
					["name" => "HERU OKTAVIANTO, S.KOM MM", "position" => "Widyaiswara", "about" => "Widyaiswara", "photo" => "http://sijawara.diskopukm.jatimprov.go.id/uploads/widyaiswaras/team-member-16.jpg"],
					["name" => "TIARA DINAR AULIA, S.I.Kom, M.M", "position" => "Widyaiswara", "about" => "Widyaiswara Hebat", "photo" => "http://sijawara.diskopukm.jatimprov.go.id/uploads/widyaiswaras/team-member-8.jpg"],
					["name" => "PRAMADATIVA ANDINI, S. GZ, , M.M", "position" => "Widyaiswara", "about" => "Lulusan handal sarjana gizi", "photo" => "http://sijawara.diskopukm.jatimprov.go.id/uploads/widyaiswaras/team-member-13.jpg"],
				];

				foreach ($data as $value) {
					Widyaiswara::create($value);
				}
    }
}
