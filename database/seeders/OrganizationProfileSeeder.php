<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\OrganizationProfile;
use Illuminate\Database\Seeder;

class OrganizationProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = json_decode(<<<'JSON'
[
  {
    "code": "1",
    "name": "Direktur Utama",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas\n\n- Memimpin dan bertanggung jawab penuh atas keseluruhan operasional dan strategi korporat\n- Mengawasi langsung fungsi-fungsi yang secara sifat harus independen dari lini bisnis (legal, audit, sekretariat korporat, IT, pengamanan) serta struktur kewilayahan (Direktur Wilayah)\n\nTanggung Jawab\n\n- Akuntabel penuh ke pemegang saham/Kementerian BUMN atas kinerja korporat; menjaga independensi fungsi audit dan legal dari intervensi operasional bisnis\n- Memastikan integritas dan governance korporat serta representasi hukum perusahaan\n- Menjadi pengambil keputusan akhir untuk isu lintas wilayah dan lintas direktorat",
    "qualification": "Kualifikasi\n\nS2 (minimal S1 dengan pengalaman sangat senior), pengalaman 15-20+ tahun termasuk pengalaman sebagai C-level/direksi di BUMN atau korporasi besar, punya rekam jejak leadership skala nasional\n\nKompetensi Teknis\n\nCorporate governance, strategic leadership, stakeholder management di level negara/kementerian, financial acumen tingkat korporat, crisis management\n\nSertifikasi\n\nTidak ada sertifikasi teknis wajib; yang relevan: sertifikasi manajemen risiko korporat (mis. CRMP), atau kelulusan program asesmen calon direksi BUMN (fit and proper test Kementerian BUMN) jika berlaku",
    "value_chain": "Framework Corporate Governance & GCG Assessment (fit and proper test)",
    "method_cost": 300000000.0
  },
  {
    "code": "1.A",
    "name": "Wakil Direktur Utama I",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas\n\n- Mengoordinasikan fungsi-fungsi yang bersifat enabler jangka panjang dan internal-facing: perencanaan strategis, pengembangan bisnis baru, pengelolaan SDM, serta pengadaan dan rantai pasok\n\nTanggung Jawab\n\n- Memastikan arah strategis korporat (termasuk rencana ekspansi/portofolio bisnis) selaras dengan kapasitas organisasi (SDM) dan rantai pasok (pengadaan-logistik)\n- Akuntabel ke Dirut atas kesiapan fondasi bisnis jangka menengah-panjang",
    "qualification": "Kualifikasi\n\nS2 manajemen/bisnis/teknik, pengalaman 15-18 tahun termasuk minimal 5-7 tahun di posisi direksi/senior eksekutif, idealnya kombinasi pengalaman strategi korporat dan operasional supply chain/SDM\n\nKompetensi Teknis\n\nStrategic planning, business development, HR strategy, supply chain & procurement governance, portfolio management\n\nSertifikasi\n\nTidak wajib; nilai tambah: sertifikasi strategic management (mis. dari lembaga manajemen strategis) atau CPSM (procurement) kalau punya background pengadaan",
    "value_chain": "Metodologi Strategic Alignment Enabler (Strategi-SDM-Pengadaan) lintas direktorat",
    "method_cost": 250000000.0
  },
  {
    "code": "1.A.1",
    "name": "Direktur Perencanaan dan Pengembangan Bisnis",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas & Tanggung Jawab\n\nMemimpin perumusan strategi korporat, perencanaan jangka panjang, dan pengembangan bisnis perusahaan di bidang pertanian dan konsultan enjinering, untuk mendorong pertumbuhan berkelanjutan dan penciptaan nilai (value creation) bagi pemegang saham.\n\n- Menetapkan arah strategis dan menyusun Rencana Jangka Panjang Perusahaan (RJPP) serta Rencana Kerja dan Anggaran Perusahaan (RKAP).\n\n- Memastikan keselarasan (alignment) strategi seluruh unit bisnis dengan visi, misi, dan sasaran korporat.\n\n- Mengarahkan pengembangan bisnis baru, ekspansi pasar, dan diversifikasi portofolio.\n\n- Membangun, mengawasi, dan mengevaluasi kemitraan strategis serta ekosistem bisnis.\n\n- Memimpin agenda transformasi digital dan transformasi organisasi.\n\n- Mengawasi tata kelola dan keberhasilan pelaksanaan proyek-proyek strategis melalui PMO.\n\n- Mendorong budaya inovasi serta mengarahkan riset dan pengembangan (R&D).\n\n- Melaporkan kinerja direktorat kepada Direktur Utama dan Dewan Komisaris.",
    "qualification": "Kualifikasi\n\nS2/S3 Manajemen, Teknik, atau Agribisnis; min. 15 thn pengalaman, 8 thn manajerial senior\n\nKompetensi Teknis\n\nManajemen strategis, corporate finance, pengembangan bisnis, tata kelola korporat\n\nSertifikasi\n\nKepemimpinan visioner, pengambilan keputusan, negosiasi tingkat tinggi; MBA / sertifikasi kepemimpinan eksekutif",
    "value_chain": "Framework Governance RJPP/RKAP & Corporate Strategy",
    "method_cost": 300000000.0
  },
  {
    "code": "1.A.1.1",
    "name": "Corporate Strartegy and Planning",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas & Tanggung Jawab\n\nMerumuskan strategi korporat, mengelola portofolio dan kinerja, serta menyediakan analitik dan valuasi sebagai dasar pengambilan keputusan.",
    "qualification": "Kualifikasi\n\nS2 Manajemen/Ekonomi/Teknik; min. 10 thn, 5 thn manajerial\n\nKompetensi Teknis\n\nPerencanaan strategis, manajemen portofolio, pemodelan keuangan, manajemen kinerja\n\nSertifikasi\n\nLeadership, analytical thinking, komunikasi strategis; sertifikasi strategy/BSC",
    "value_chain": "Metodologi Strategic Planning (PESTEL, SWOT/TOWS, Five Forces)",
    "method_cost": 300000000.0
  },
  {
    "code": "1.A.1.1.1",
    "name": "Strategy Planning",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas & Tanggung Jawab\n\n- Menyusun rencana strategis jangka panjang (RJPP) dan rencana kerja tahunan (RKAP).\n\n- Melakukan analisis lingkungan bisnis: PESTEL, SWOT/TOWS, Porter's Five Forces, dan analisis kompetitor.\n\n- Merumuskan visi, misi, sasaran strategis, dan inisiatif strategis korporat.\n\n- Melakukan cascading dan alignment strategi ke seluruh unit bisnis (strategy map).\n\n- Menyusun roadmap strategis serta melakukan scenario planning dan analisis risiko strategis.",
    "qualification": "Kualifikasi\n\n- Manager: S1/S2 (7+ thn);\n- Analyst: S1 (3+ thn)\n\nKompetensi Teknis\n\nAnalisis strategis (SWOT/PESTEL/Five Forces), penyusunan RJPP/RKAP, scenario planning\n\nSertifikasi\n\nRiset, penulisan korporat, presentasi; pelatihan corporate strategy",
    "value_chain": "SOP Penyusunan RJPP/RKAP & Strategy Map Cascading",
    "method_cost": 150000000.0
  },
  {
    "code": "1.A.1.1.2",
    "name": "Portfolio and Performance",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas & Tanggung Jawab\n\n- Mengelola portofolio bisnis dan investasi perusahaan secara terintegrasi.\n\n- Mengembangkan dan memantau sistem manajemen kinerja (KPI, Balanced Scorecard, OKR).\n\n- Melakukan evaluasi portofolio (BCG Matrix, GE-McKinsey) dan memberi rekomendasi alokasi sumber daya.\n\n- Menyusun laporan kinerja korporat berkala (bulanan, triwulanan, tahunan).\n\n- Memantau pencapaian target strategis dan memberi sinyal dini (early warning) atas deviasi kinerja.",
    "qualification": "Kualifikasi\n\n- Manager: S1/S2 (7+ thn);\n- Analyst: S1 (3+ thn)\n\nKompetensi Teknis\n\nBalanced Scorecard, KPI/OKR, evaluasi portofolio, pelaporan kinerja\n\nSertifikasi\n\nKetelitian, manajemen data; sertifikasi BSC/Performance Management",
    "value_chain": "Sistem Balanced Scorecard/OKR & Evaluasi Portofolio (BCG/GE-McKinsey)",
    "method_cost": 200000000.0
  },
  {
    "code": "1.A.1.1.3",
    "name": "Business and Analytics and Valuation",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas & Tanggung Jawab\n\n- Melakukan analisis data bisnis dan menyediakan business intelligence bagi manajemen.\n\n- Menyusun studi kelayakan (feasibility study) proyek dan investasi.\n\n- Melakukan valuasi proyek/perusahaan (DCF, NPV, IRR, Payback Period) dan pemodelan keuangan.\n\n- Melakukan analisis sensitivitas, analisis skenario, dan analisis risiko keuangan.\n\n- Melakukan benchmarking, analisis pasar, dan pemodelan prediktif untuk dukungan keputusan.",
    "qualification": "Kualifikasi\n\n- Manager: S1/S2 Keuangan/Statistik (7+ thn); \n- Analyst: S1 (3+ thn)\n\nKompetensi Teknis\n\nValuasi (DCF/NPV/IRR), feasibility study, pemodelan keuangan, data analytics, BI\n\nSertifikasi\n\nBerpikir kuantitatif, problem solving; CFA / FMVA / sertifikasi data analytics",
    "value_chain": "Metodologi Valuasi (DCF/NPV/IRR) & Business Intelligence Tools",
    "method_cost": 250000000.0
  },
  {
    "code": "1.A.1.2",
    "name": "Business Development, Partnership and Technology",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas & Tanggung Jawab\n\nmendorong pertumbuhan melalui peluang bisnis baru, kemitraan dan ekosistem, serta pemanfaatan teknologi digital sebagai pemampu bisnis.",
    "qualification": "Kualifikasi\n\nS2 Manajemen/Teknik; min. 10 thn, 5 thn manajerial\n\nKompetensi Teknis\n\nStrategi pengembangan bisnis, manajemen kemitraan, strategi teknologi / digital\n\nSertifikasi\n\nLeadership, networking, negosiasi; sertifikasi business development",
    "value_chain": "Metodologi Business Model Canvas & Digital Transformation Roadmap",
    "method_cost": 250000000.0
  },
  {
    "code": "1.A.1.2.1",
    "name": "Business Development",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas & Tanggung Jawab\n\n- Mengidentifikasi dan mengevaluasi peluang bisnis baru di sektor pertanian dan jasa enjinering.\n\n- Mengembangkan pasar dan segmen pelanggan baru (market development).\n\n- Menyusun proposal bisnis, business case, dan dokumen penawaran (bid/tender).\n\n- Melakukan negosiasi serta akuisisi proyek dan kontrak.\n\n- Mengembangkan model bisnis baru menggunakan Business Model Canvas dan strategi go-to-market.",
    "qualification": "Kualifikasi\n\n- Manager: S1/S2 (7+ thn); \n- Officer: S1 (3+ thn)\n\nKompetensi Teknis\n\nIdentifikasi peluang, penyusunan proposal / tender, model bisnis, go-to-market\n\nSertifikasi\n\nKomunikasi persuasif, negosiasi, orientasi target; pelatihan sales & BD",
    "value_chain": "SOP Identifikasi Peluang Bisnis & Business Case/Proposal",
    "method_cost": 150000000.0
  },
  {
    "code": "1.A.1.2.2",
    "name": "Partnership and Ecosystem",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas & Tanggung Jawab\n\n- Membangun dan mengelola kemitraan strategis (joint venture, KSO, aliansi strategis).\n\n- Mengembangkan ekosistem bisnis: pemasok, mitra teknologi, akademisi, lembaga keuangan, dan pemerintah.\n\n- Mengelola hubungan pemangku kepentingan (stakeholder) eksternal.\n\n- Menyusun dan menegosiasikan perjanjian kerja sama (MoU, PKS, kontrak kemitraan).\n\n- Mengidentifikasi peluang kolaborasi sepanjang rantai nilai (value chain partnership).",
    "qualification": "Kualifikasi\n\n- Manager: S1/S2 (7+ thn);\n- Officer: S1 (3+ thn)\n\nKompetensi Teknis\n\nManajemen kemitraan (JV/KSO), penyusunan MoU/PKS, relationship management\n\nSertifikasi\n\nDiplomasi, manajemen stakeholder; pelatihan kontrak & kemitraan",
    "value_chain": "Sistem Manajemen Kemitraan (JV/KSO) & MoU/PKS Tracking",
    "method_cost": 200000000.0
  },
  {
    "code": "1.A.1.2.3",
    "name": "Technology and Digital for Business Enablement",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas & Tanggung Jawab\n\n- Merumuskan strategi pemanfaatan teknologi dan digital untuk mendukung bisnis.\n\n- Mengembangkan solusi digital: AgriTech, smart/precision farming, dan digital engineering.\n\n- Memimpin inisiatif transformasi digital dan otomasi proses bisnis.\n\n- Mengelola platform digital, arsitektur data, dan tata kelola data perusahaan.\n\n- Mengevaluasi dan mengadopsi teknologi baru (IoT, AI, big data, remote sensing, drone).",
    "qualification": "Kualifikasi\n\n- Lead: S1/S2 Informatika/SI (8+ thn);\n- staf: S1 (3+ thn)\n\nKompetensi Teknis\n\nTransformasi digital, enterprise architecture, IoT/AI/big data, AgriTech, data engineering\n\nSertifikasi\n\nManajemen produk digital, agile; sertifikasi cloud / data (AWS/Azure/GCP, TOGAF)",
    "value_chain": "Platform AgriTech/IoT/Big Data & Data Governance Architecture",
    "method_cost": 500000000.0
  },
  {
    "code": "1.A.1.3",
    "name": "PMO (Project Management Office) and Transformation",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas & Tanggung Jawab\n\n- Menetapkan standar, metodologi, dan tata kelola manajemen proyek (PMBOK, PRINCE2, Agile).\n\n- Memantau dan mengendalikan portofolio proyek strategis (jadwal, biaya, mutu, ruang lingkup).\n\n- Menyediakan quality assurance, manajemen risiko proyek, dan dukungan governance.\n\n- Memimpin program transformasi organisasi dan manajemen perubahan (ADKAR, Kotter 8 Step).\n\n- Menyusun pelaporan status proyek dan dashboard portofolio bagi manajemen.\n\n- Melakukan capacity building dan pembinaan kompetensi manajemen proyek di seluruh unit.",
    "qualification": "Kualifikasi\n\n- Head: S1/S2 (8+ thn);\n- PM/Officer: S1 (3–5 thn)\n\nKompetensi Teknis\n\nMetodologi proyek (PMBOK/PRINCE2/Agile), penjadwalan, manajemen risiko, EVM\n\nSertifikasi\n\nKepemimpinan proyek, koordinasi lintas tim; PMP / PRINCE2 / Scrum / change management",
    "value_chain": "Metodologi PMBOK/PRINCE2/Agile + Change Management (ADKAR/Kotter)",
    "method_cost": 400000000.0
  },
  {
    "code": "1.A.1.4",
    "name": "Research, Innovation and Development",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas & Tanggung Jawab\n\n- Melakukan riset pasar, riset teknologi, dan analisis tren industri pertanian serta enjinering.\n\n- Mengembangkan inovasi produk dan layanan baru sesuai kebutuhan pasar.\n\n- Mengembangkan teknologi pertanian (precision agriculture, benih/varietas, budidaya) dan solusi enjinering.\n\n- Mengelola pipeline inovasi melalui proses Stage-Gate dan Technology Readiness Level (TRL).\n\n- Menjalin kolaborasi riset dengan universitas, lembaga riset, dan mitra teknologi.\n\n- Mengelola Hak Kekayaan Intelektual (HKI/paten) serta menjalankan pilot project dan proof of concept.",
    "qualification": "Kualifikasi\n\n- Head: S2/S3 Pertanian/Teknik (8+ thn);\n- Peneliti: S2/S3\n\nKompetensi Teknis\n\nMetodologi riset, agronomi/precision agriculture, riset enjinering, manajemen inovasi (Stage-Gate/TRL)\n\nSertifikasi\n\nBerpikir kritis, kolaborasi riset, manajemen HKI; sertifikasi riset/inovasi",
    "value_chain": "Metodologi Innovation Pipeline (Stage-Gate/TRL) & Sistem HKI",
    "method_cost": 300000000.0
  },
  {
    "code": "1.A.2",
    "name": "Direktur SDM",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n\nA. Perumusan Strategi dan Kebijakan Human Capital\n1. Menyusun strategi, kebijakan, dan arah pengelolaan Human Capital yang selaras dengan visi, misi, serta sasaran strategis perusahaan.\n2. Mengembangkan kebijakan pengelolaan SDM yang mencakup perencanaan tenaga kerja, pengembangan organisasi, manajemen talenta, hubungan industrial, serta operasional SDM.\n3. Memberikan arahan strategis kepada seluruh fungsi Human Capital dalam mendukung pencapaian target bisnis perusahaan.\n4. Mengevaluasi efektivitas kebijakan Human Capital sebagai dasar pengambilan keputusan Direksi.\n\nB. Pengelolaan Human Capital Services, Strategy, dan Operations\n1. Mengarahkan pelaksanaan fungsi Human Capital Services, Human Capital Strategy, serta Human Capital & General Affairs Operations agar berjalan secara efektif, terintegrasi, dan sesuai target perusahaan.\n2. Mengendalikan pelaksanaan program rekrutmen, pengembangan SDM, manajemen kinerja, kompensasi, hubungan karyawan, hubungan industrial, administrasi kepegawaian, dan General Affairs.\n3. Memastikan seluruh program Human Capital mendukung peningkatan produktivitas, kompetensi, serta keberlanjutan organisasi.\n4. Mengembangkan sistem dan proses Human Capital yang adaptif terhadap kebutuhan bisnis dan perubahan organisasi.\n\nC. Pengembangan Organisasi dan Tata Kelola SDM\n1. Mengarahkan pengembangan struktur organisasi, kompetensi jabatan, sistem manajemen kinerja, serta pengembangan talenta sesuai kebutuhan perusahaan.\n2. Mengendalikan implementasi budaya perusahaan, nilai-nilai AKHLAK BUMN, serta program employee engagement.\n3. Membangun hubungan kerja yang harmonis dengan karyawan, serikat pekerja, dan pemangku kepentingan terkait.\n4. Memastikan seluruh pengelolaan SDM dilaksanakan sesuai regulasi ketenagakerjaan dan tata kelola perusahaan yang baik.\n\nD. Monitoring, Evaluasi, dan Pengambilan Keputusan Strategis\n1. Mengendalikan monitoring dan evaluasi pelaksanaan seluruh program Human Capital berdasarkan indikator kinerja perusahaan.\n2. Menganalisis data Human Capital sebagai dasar penyusunan strategi, pengambilan keputusan, dan pengembangan organisasi.\n3. Menyampaikan laporan kinerja Human Capital kepada Direksi serta memberikan rekomendasi strategis untuk peningkatan efektivitas organisasi.\n4. Mendorong inovasi, transformasi, dan digitalisasi dalam pengelolaan Human Capital.\n\nE. Tata Kelola, Kepatuhan, dan Manajemen Risiko\n1. Memastikan seluruh proses pengelolaan Human Capital dilaksanakan sesuai kebijakan perusahaan, regulasi ketenagakerjaan, serta prinsip Good Corporate Governance (GCG).\n2. Mengendalikan implementasi standar ISO, Sistem Manajemen Anti Penyuapan (SMAP ISO 37001), dan kebijakan perusahaan dalam lingkup Human Capital.\n3. Memastikan pengelolaan risiko, keamanan data, dan kerahasiaan informasi SDM dilaksanakan sesuai ketentuan yang berlaku.\n4. Menginternalisasikan nilai-nilai AKHLAK BUMN dalam seluruh aktivitas pengelolaan Human Capital.",
    "qualification": "Kualifikasi\n\n1. Pendidikan Minimal S1 Psikologi, Manajemen SDM, Manajemen, Hukum, atau bidang terkait. Pendidikan Magister (S2) di bidang Manajemen, Manajemen SDM, Psikologi Industri dan Organisasi, atau bidang terkait menjadi nilai tambah.\n2. Pengalaman Kerja Minimal 12 tahun di bidang Human Capital. Minimal 5 tahun pada posisi senior manajerial atau setara yang membawahi fungsi Human Capital secara menyeluruh.\n\nKompetensi\n1. Strategic Human Capital Leadership.\n2. Human Capital Services, Strategy, & Operations Management.\n3. Organization Development, Talent Management, & Performance Management.\n4. Leadership, Business Acumen, & Stakeholder Management.\n5. Human Capital Transformation, Digitalization, & Analytics.\n6. Regulasi Ketenagakerjaan, Good Corporate Governance (GCG), dan Tata Kelola SDM.\n\nSertifikasi\n1. Sertifikasi Profesi Human Capital (BNSP/CHRP).\n2. Sertifikasi Human Capital Director/Executive Leadership (menjadi nilai tambah).\n\nTraining\n1. Strategic Human Capital Management.\n2. Executive Leadership Development.\n3. Human Capital Transformation & Organization Development.\n4. Corporate Governance & Risk Management.\n5. Human Capital Analytics & Digital HR.\n6. Industrial Relations & Employment Law.",
    "value_chain": "Framework Strategic Human Capital Management",
    "method_cost": 250000000.0
  },
  {
    "code": "1.A.2.1",
    "name": "HC Service",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n\nA. Perencanaan Strategis Human Capital Services\n1. Menyusun strategi, kebijakan, dan rencana kerja Human Capital Services yang meliputi pengelolaan rekrutmen, pengembangan SDM, onboarding, dan layanan SDM lainnya sesuai kebutuhan perusahaan.\n2. Berkoordinasi dengan Direktur SDM dan unit kerja dalam menyusun perencanaan kebutuhan tenaga kerja, kompetensi jabatan, serta program pengembangan organisasi.\n3. Mengendalikan pelaksanaan program Human Capital Services agar selaras dengan strategi bisnis dan target perusahaan.\n\nB. Pengelolaan Talent Acquisition, Onboarding, dan Human Resources Business Partnership\n1. Mengarahkan dan mengendalikan pelaksanaan proses rekrutmen, seleksi, onboarding, serta pemenuhan kebutuhan tenaga kerja secara efektif dan tepat waktu.\n2. Memastikan pelaksanaan fungsi Human Resources Business Partner dalam memberikan konsultasi dan dukungan strategis kepada unit kerja terkait kebutuhan SDM.\n3. Mengembangkan strategi akuisisi talenta, employer branding, serta pengelolaan hubungan dengan institusi maupun pihak eksternal dalam mendukung proses rekrutmen.\n\nC. Pengelolaan Pengembangan SDM dan Talent Management\n1. Mengarahkan penyusunan dan pelaksanaan program pengembangan kompetensi, pengembangan karier, onboarding, program magang, serta pengelolaan talenta.\n2. Mengendalikan penyusunan dokumen pendukung pengembangan SDM, termasuk job description, kompetensi jabatan, serta administrasi pegawai baru sesuai kebutuhan organisasi.\n3. Memastikan terselenggaranya program pengembangan SDM yang mendukung peningkatan kompetensi, produktivitas, dan keberlanjutan organisasi.\n\nD. Monitoring, Evaluasi, Analisis Data, dan Pelaporan Human Capital Services\n1. Mengendalikan monitoring dan evaluasi pelaksanaan program rekrutmen, pengembangan SDM, serta layanan Human Capital Services.\n2. Menganalisis data Human Capital, produktivitas SDM, efektivitas rekrutmen, serta kebutuhan pengembangan kompetensi sebagai dasar penyusunan rekomendasi kepada manajemen.\n3. Memastikan penyusunan laporan Human Capital Services dilakukan secara akurat, tepat waktu, dan sesuai kebutuhan perusahaan.",
    "qualification": "Kualifikasi\n\n1. Pendidikan minimal S1 Psikologi, Manajemen SDM, Manajemen, Hukum, atau bidang terkait.\n2. Pengalaman Kerja minimal 8 tahun di bidang Human Capital. Minimal 3 tahun pada posisi manajerial di bidang Talent Acquisition, Pengembangan SDM, atau Human Capital.\n\nKompetensi\n1. Strategic Human Capital Management.\n2. Talent Acquisition dan Human Resources Business Partner.\n3. Learning & Development serta Talent Management.\n4. Leadership, Stakeholder Management, dan Communication.\n5. Human Capital Analytics, HRIS, dan Workforce Planning.\n6. Regulasi Ketenagakerjaan dan Tata Kelola SDM.\n\nSertifikasi\n1. Sertifikasi Profesi Human Capital (BNSP/CHRP).\n2. Sertifikasi Talent Management atau HR Business Partner (menjadi nilai tambah).\n\nTraining\n1. Strategic Human Capital Management.\n2. Talent Acquisition & Employer Branding.\n3. Learning & Development.\n4. Human Resources Business Partner.\n5. Talent Management & Organization Development.\n6. Human Capital Analytics.",
    "value_chain": "Sistem Applicant Tracking System (ATS) & Learning Management System",
    "method_cost": 350000000.0
  },
  {
    "code": "1.A.2.1.1",
    "name": "Talent Aqcuisition-Human Resources Business",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n\nA.       Strategi dan Perencanaan Rekrutmen\n1.        Merumuskan strategi rekrutmen jangka pendek dan menengah berdasarkan kebutuhan tenaga kerja masing-masing divisi dan direktorat, memastikan pendekatan pencarian kandidat yang tepat sasaran dan efisien.\n2.        Berkoordinasi dengan Direktur SDM dan pimpinan unit kerja untuk memahami kebutuhan kompetensi, profil kandidat ideal, dan rencana pengembangan organisasi yang berimplikasi pada kebutuhan rekrutmen.\n3.        Memimpin dan mengelola proses rekrutmen, mulai dari perencanaan, penjadwalan, hingga penyelesaian proses seleksi secara efektif dan tepat waktu.\n4.        Mengidentifikasi dan mengembangkan saluran rekrutmen (sourcing channels) yang efektif, termasuk platform digital (LinkedIn, Jobstreet), referral internal, job fair, dan kerja sama dengan institusi pendidikan.\n\nB.        Pelaksanaan Proses Seleksi dan Penilaian Kandidat\n1.        Mensupervisi dan menjalankan seluruh tahapan proses rekrutmen secara end-to-end, meliputi penyaringan CV (filtering), wawancara awal, penjadwalan seleksi lanjutan, hingga onboarding karyawan baru.\n2.        Menentukan jenis dan instrumen psikotest yang sesuai dengan level dan kebutuhan posisi yang direkrut, berkoordinasi dengan vendor psikotest eksternal apabila diperlukan, serta memastikan proses asesmen berjalan valid dan terstandar.\n3.        Melaksanakan wawancara berbasis kompetensi untuk menilai kesesuaian kandidat terhadap kompetensi teknis dan perilaku yang dipersyaratkan oleh jabatan.\n4.        Mengelola proses negosiasi kompensasi dengan kandidat terpilih berdasarkan struktur dan skala upah yang ditetapkan perusahaan, dan mengajukan usulan penetapan gaji kepada Direktur SDM untuk mendapatkan persetujuan.\n5.        Mengelola dashboard rekrutmen dan dashboard psikotest secara akurat dan mutakhir, memastikan seluruh data kandidat, mulai dari tahap pendaftaran hingga onboarding tercatat lengkap dan dapat ditelusuri sewaktu-waktu.\n6.        Mengelola hubungan kerja dengan vendor psikotest eksternal, termasuk koordinasi pemilihan alat tes, penjadwalan pelaksanaan, dan penanganan hambatan teknis yang muncul selama proses asesmen berlangsung.\n\nC.        Analisis Data Rekrutmen dan Pelaporan\n1.        Menyusun laporan periodik perkembangan proses rekrutmen aktif, mencakup status setiap posisi, jumlah kandidat di setiap tahapan, dan estimasi waktu penyelesaian.\n2.        Menyusun laporan periodic analisis kinerja rekrutmen berbasis data, meliputi time-to-fill, quality of hire, source effectiveness, dan pemenuhan kebutuhan tenaga kerja dibandingkan target yang ditetapkan.\n3.        Menganalisis tren dan pola data rekrutmen untuk mengidentifikasi bottleneck dalam proses seleksi, termasuk kesulitan pencarian kandidat akibat mismatch latar belakang pendidikan dan pengalaman, serta merumuskan langkah perbaikan yang dapat segera dieksekusi.\n4.        Menyajikan hasil analisis rekrutmen kepada Direktur SDM secara berkala sebagai bahan evaluasi strategi dan pengambilan keputusan terkait kebutuhan tenaga kerja perusahaan.\n5.        Memastikan keakuratan dan kelengkapan data dalam dashboard rekrutmen dan dashboard psikotest, menjaga integritas data kandidat dan hasil asesmen sebagai aset informasi SDM yang bersifat rahasia.\n\nD.        HR Business Partnership\n1.        Bertindak sebagai HR Business Partner bagi divisi dan direktorat kelolaan, membantu pimpinan unit kerja dalam mengidentifikasi kebutuhan kompetensi, merencanakan kebutuhan tenaga kerja, dan menyelaraskan strategi SDM dengan target bisnis divisi.\n2.        Berkoordinasi dengan tim HR lainnya terkait fungsi SDM secara menyeluruh, termasuk penyelarasan SOP rekrutmen, pemutakhiran struktur organisasi, dan integrasi proses rekrutmen dengan fungsi onboarding, pelatihan, dan manajemen kinerja.\n3.        Memberikan konsultasi dan rekomendasi kepada pimpinan divisi terkait profil kandidat yang paling sesuai dengan kebutuhan tim, standar kompetensi jabatan, dan strategi akuisisi talenta yang relevan dengan konteks bisnis perusahaan.\n4.        Mendukung proses pengembangan organisasi, termasuk penyusunan atau pemutakhiran job description, job grading, dan peta kompetensi jabatan yang diperlukan sebagai fondasi proses rekrutmen yang tepat sasaran.\n5.        Mengidentifikasi kebutuhan pelatihan (training needs) berdasarkan hasil asesmen kandidat dan gap kompetensi yang ditemukan selama proses rekrutmen, dan menyampaikan rekomendasi program pengembangan kepada Direktur SDM.",
    "qualification": "Kualifikasi\n1.        Pendidikan Sarjana (S1) semua jurusan\n2.        Pengalaman kerja minimal 4-8 tahun pengalaman di bidang rekrutmen atau sumber daya manusia.\n\nKompetensi\n1.        Teknik wawancara berbasis kompetensi (Behavioral Event Interview/BEI) untuk menilai kesesuaian kandidat secara komprehensif.\n2.        Pengelolaan Applicant Tracking System (ATS) dan dashboard rekrutmen untuk monitoring pipeline kandidat secara real-time.\n3.        Penggunaan platform rekrutmen digital: LinkedIn Recruiter, Jobstreet, dan tools sourcing kandidat lainnya.\n4.        Analisis data rekrutmen menggunakan Microsoft Excel (pivot table, dashboard) untuk laporan kinerja mingguan dan bulanan.\n5.        Pemahaman psikologi industri dan pemilihan instrumen psikotest yang sesuai dengan level dan kebutuhan jabatan.\n6.        Pemahaman regulasi ketenagakerjaan Indonesia (UU Cipta Kerja, PP Pengupahan) yang relevan dengan proses rekrutmen dan penetapan kompensasi.\n\nSertifikasi\n1.           Sertifikasi Psikolog / Asesor Kompetensi (LSP P3) — jika tersedia\n\nTraining\n1.        Strategi Talent Acquisition dan Employer Branding\n2.        HR Business Partnering dan Konsultasi SDM Strategis\n3.        Analisis Data SDM dan HR Metrics untuk Pengambilan Keputusan\n4.        Regulasi Ketenagakerjaan dan Manajemen Hubungan Industrial\n5.        Pelatihan Behavioral Event Interview (BEI) dan Teknik Asesmen Kompetensi",
    "value_chain": "Metodologi BEI (Behavioral Event Interview) & Employer Branding",
    "method_cost": 150000000.0
  },
  {
    "code": "1.A.2.1.2",
    "name": "People Development-Talent Management",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n\nA.        Penyusunan Dokumen dan Administrasi Pegawai Baru\n1.        Membuat tabel gaji pegawai baru sebagai pengajuan rencana gaji kepada Direksi.\n2.        Menyusun Offering Letter dan kontrak pegawai baru untuk ditandatangani saat pegawai mulai bekerja.\n3.        Menyusun jobdesc untuk kontrak pegawai baru, serta merekap jobdesc pegawai eksisting.\n4.        Membuat laporan penerimaan karyawan baru untuk disampaikan kepada user.\n\nB.        Pengelolaan Onboarding dan Program Magang\n1.        Melakukan proses onboarding karyawan, meliputi penjelasan dan penandatanganan kontrak, orientasi, serta pengenalan lingkungan kerja.\n2.        Mengelola proses magang, mulai dari pengajuan, penerimaan, hingga pengajuan uang saku peserta magang.\n3.        Melakukan interview pegawai baru sesuai kebutuhan rekrutmen.\n\nC.        Pengurusan Tenaga Kerja Asing dan Pelaporan\n1.        Mengurus izin kerja dan izin tinggal Tenaga Kerja Asing (TKA), termasuk pembuatan visa dan RPTKA.\n2.        Membuat laporan bulanan, ragab, triwulan, dan semester terkait kegiatan pengembangan SDM.\n3.        Merekap laporan produktivitas (Human Capital Return on Investment/HCROI) sebagai bahan evaluasi manajemen.\n\nD.        Koordinasi Internal Pendukung Operasional SDM\n1.        Berkoordinasi dengan Divisi Legal dan Divisi Keuangan terkait pengurusan Tenaga Kerja Asing (TKA).\n2.        Berkoordinasi dengan Divisi Keuangan terkait pembayaran vendor jasa pendukung SDM.\n3.        Berkoordinasi dengan Divisi Pengadaan terkait pengadaan psikotes dan sistem HRIS.\n4.        Berkoordinasi dengan Bagian Umum dan BM terkait penyediaan fasilitas kerja pegawai baru.",
    "qualification": "Kualifikasi\n1.        Pendidikan Sarjana (S1) / sederajat\n2.        Pengalaman kerja minimal 4-8 tahun dengan 2 tahun di bidang rekrutmen / pelatihan / pengembangan SDM.\n\nKompetensi\n1.        Penyusunan Dokumen dan Administrasi Pegawai Baru\n2.        Pengelolaan Onboarding dan Program Magang\n3.        Pengurusan Tenaga Kerja Asing dan Pelaporan\n4.        Koordinasi Internal Pendukung Operasional SDM\n5.        Penguasaan Manajemen Sumber Daya Manusia dan dasar-dasar Psikologi Industri.\n6.        Kemampuan mengoperasikan Microsoft Office dan Microsoft Teams.\n7.        Kemampuan menyusun Rencana Anggaran Biaya (RAB) dan menganalisis data menggunakan Excel.\n\nSertifikasi\n1.      Sertifikasi Profesi Pengembangan SDM/Talent Management (jika tersedia).\n\nTraining\n1.        Perencanaan dan Pengembangan Karier Karyawan.\n2.        Penyusunan Kontrak Kerja dan Dokumen Onboarding Pegawai Baru.\n3.        Pengurusan Visa dan RPTKA untuk Tenaga Kerja Asing.\n4.        Analisis Produktivitas SDM (HCROI) dan Penyusunan Laporan Manajemen.",
    "value_chain": "Sistem Talent Management & Career Development Framework, Leadership Development",
    "method_cost": 15200000000.0
  },
  {
    "code": "1.A.2.2",
    "name": "HC Strategy",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n\nA. Perencanaan Strategis Human Capital\n1. Menyusun strategi, kebijakan, dan program Human Capital yang selaras dengan visi, misi, serta sasaran bisnis perusahaan.\n2. Mengembangkan sistem dan kebijakan Human Capital yang mendukung efektivitas pengelolaan SDM, organisasi, dan produktivitas perusahaan.\n3. Mengoordinasikan penyusunan rencana kerja serta target kinerja HC Strategy sesuai kebutuhan organisasi.\n4. Memberikan rekomendasi strategis kepada Direktur SDM terkait pengembangan kebijakan Human Capital.\n\nB. Pengelolaan Sistem Manajemen Kinerja dan Remunerasi\n1. Mengarahkan penyusunan dan pengembangan sistem manajemen kinerja, kompensasi, benefit, job grading, dan evaluasi jabatan.\n2. Memastikan implementasi sistem penilaian kinerja, KPI, serta kebijakan remunerasi berjalan sesuai ketentuan perusahaan.\n3. Mengevaluasi efektivitas sistem manajemen kinerja dan kompensasi sebagai dasar peningkatan produktivitas dan kesejahteraan karyawan.\n4. Mengembangkan kebijakan pengelolaan organisasi yang mendukung pencapaian target perusahaan.\n\nC. Pengelolaan Hubungan Karyawan dan Hubungan Industrial\n1. Mengarahkan pelaksanaan program employee engagement, komunikasi internal, dan budaya perusahaan untuk meningkatkan keterikatan karyawan.\n2. Mengendalikan pelaksanaan hubungan industrial serta memastikan kepatuhan terhadap regulasi ketenagakerjaan dan kebijakan perusahaan.\n3. Mengelola penyelesaian isu hubungan industrial serta membangun hubungan kerja yang harmonis dengan karyawan maupun serikat pekerja.\n4. Memberikan arahan strategis terkait pengelolaan hubungan kerja guna menciptakan lingkungan kerja yang kondusif.\n\nD. Monitoring, Evaluasi, dan Pengembangan Human Capital Strategy\n1. Mengendalikan monitoring dan evaluasi pelaksanaan program HC Strategy berdasarkan indikator kinerja yang telah ditetapkan.\n2. Menganalisis data Human Capital sebagai dasar penyusunan rekomendasi strategis dan pengambilan keputusan manajemen.\n3. Menyusun laporan pelaksanaan program HC Strategy secara berkala kepada Direktur SDM.\n4. Mengembangkan inovasi dan perbaikan berkelanjutan terhadap sistem, kebijakan, dan proses Human Capital.",
    "qualification": "Kualifikasi\n1. Pendidikan minimal S1 Psikologi, Manajemen SDM, Manajemen, Hukum, atau bidang terkait.\n2. Pengalaman Kerja minimal 8 tahun di bidang Human Capital. Minimal 3 tahun pada posisi manajerial yang menangani Human Capital Strategy, Performance Management, Compensation, Employee Engagement, atau Industrial Relations.\n\nKompetensi\n1. Strategic Human Capital Management.\n2. Performance Management & Compensation.\n3. Employee Engagement & Industrial Relations.\n4, Leadership, Communication, dan Stakeholder Management.\n5. Human Capital Analytics & Organization Development.\n6. Regulasi Ketenagakerjaan, GCG, dan Tata Kelola SDM.\n\nSertifikasi\n1. Sertifikasi Profesi Human Capital (BNSP/CHRP).\n2. Sertifikasi Compensation & Benefit atau Industrial Relations (menjadi nilai tambah).\n\nTraining\n1. Strategic Human Capital Management.\n2. Performance Management & Compensation.\n3. Employee Engagement & Culture Development.\n4. Industrial Relations & Employment Law.\n5. Human Capital Analytics.\n6. Leadership Development.",
    "value_chain": "Sistem Manajemen Kinerja & Remunerasi (KPI/Job Grading)",
    "method_cost": 300000000.0
  },
  {
    "code": "1.A.2.2.1",
    "name": "Compensation and Performance Management",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n\nA. Perencanaan Sistem Manajemen Kinerja dan Kompensasi\n1. Menyusun kebijakan, program, dan sistem manajemen kinerja serta kompensasi yang selaras dengan strategi perusahaan.\n2. Mengembangkan sistem Key Performance Indicator (KPI), evaluasi kinerja, dan pengelolaan remunerasi sesuai kebutuhan organisasi.\n3. Menyusun struktur dan skala upah, kebijakan benefit, serta program penghargaan karyawan.\n4. Berkoordinasi dengan unit kerja dalam penyusunan target kinerja dan kebutuhan pengelolaan remunerasi.\n\nB. Pengelolaan Manajemen Kinerja dan Remunerasi\n1. Mengelola implementasi sistem penilaian kinerja, KPI, serta evaluasi pencapaian kinerja karyawan.\n2. Mengelola pelaksanaan job evaluation, job grading, serta penyusunan struktur organisasi sesuai kebutuhan perusahaan.\n3. Mengelola proses review kompensasi, benefit, dan remunerasi sesuai kebijakan perusahaan.\n4. Memberikan rekomendasi terkait pengelolaan sistem penghargaan dan peningkatan kinerja karyawan.\n\nC. Analisis Data dan Pengembangan Sistem\n1. Melakukan analisis data kinerja, kompensasi, dan produktivitas sebagai dasar penyusunan kebijakan Human Capital.\n2. Melaksanakan evaluasi efektivitas sistem manajemen kinerja dan remunerasi secara berkala.\n3. Menyusun rekomendasi penyempurnaan sistem berdasarkan hasil evaluasi dan kebutuhan organisasi.\n4. Mendukung pengembangan sistem Human Capital yang berbasis data dan berorientasi pada peningkatan produktivitas.\n\nD. Monitoring, Evaluasi, dan Pelaporan\n1. Melaksanakan monitoring dan evaluasi pelaksanaan manajemen kinerja dan kompensasi di seluruh unit kerja.\n2. Menyusun laporan pelaksanaan KPI, remunerasi, dan produktivitas SDM sebagai bahan pengambilan keputusan manajemen.\n3. Memastikan data kinerja dan kompensasi terdokumentasi secara akurat dan tepat waktu.",
    "qualification": "Kualifikasi\n1. Minimal S1 Psikologi, Manajemen SDM, Manajemen, Akuntansi, atau bidang terkait.\n2. Pengalaman Kerja Minimal 4–8 tahun di bidang Performance Management, Compensation & Benefit, atau Human Capital.\n\nKompetensi\n1. Performance Management & KPI.\n2. Compensation, Benefit, dan Job Evaluation.\n3. Job Grading & Organization Structure.\n4. Human Capital Analytics & Microsoft Excel.\n5. Regulasi Ketenagakerjaan.\n6. Analytical Thinking & Problem Solving.\n\nSertifikasi\n1. Sertifikasi Compensation & Benefit atau Human Capital (BNSP).\n\nTraining\n1. Performance Management System.\n2. Compensation & Benefit Management.\n3. Job Evaluation & Job Grading.\n4. KPI Development.\n5. Human Capital Analytics.\n6. Microsoft Excel for HR.",
    "value_chain": "Metodologi Job Evaluation/Grading & Sistem KPI, Performance Management",
    "method_cost": 5200000000.0
  },
  {
    "code": "1.A.2.2.2",
    "name": "Employee Engagement Management",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n \n A. Penanganan Konflik & Konseling Karyawan\n 1. Menjadi penengah yang objektif jika terjadi konflik antara karyawan dengan sesama rekan kerja maupun dengan atasan (user).\n 2. Mengelola saluran pengaduan karyawan (whistleblowing system atau kotak saran) dan menindaklanjuti keluhan terkait lingkungan kerja secara rahasia.\n 3. Melakukan investigasi menyeluruh jika terjadi pelanggaran berat seperti pelecehan, diskriminasi, kecurangan (fraud), atau perundungan (bullying) di tempat kerja.\n \n B. Kepatuhan Hukum & Regulasi\n 1. Merancang, memperbarui, dan mendaftarkan Peraturan Perusahaan atau Perjanjian Kerja Bersama (PKB) agar selalu sejalan dengan Undang-Undang Ketenagakerjaan yang berlaku.\n 2. Mewakili perusahaan dalam menjalin hubungan dan komunikasi yang baik dengan Dinas Tenaga Kerja (Disnaker), Serikat Pekerja (jika ada), atau lembaga eksternal terkait.\n 3. Memastikan seluruh kebijakan operasional perusahaan tidak melanggar hak-hak dasar pekerja guna menghindari perselisihan hubungan industrial (PHI).\n\n C. Manajemen Kedisiplinan & Penegakan Aturan\n 1. Memproses pemberian sanksi bagi karyawan yang melanggar aturan, mulai dari teguran lisan, Surat Peringatan (SP 1, 2, 3), hingga proses Pemutusan Hubungan Kerja (PHK).\n 2. Mensosialisasikan kode etik (code of conduct) dan peraturan perusahaan secara berkala kepada seluruh karyawan agar tingkat pelanggaran dapat ditekan.\n\n D. Keterikatan Karyawan & Kesejahteraan\n 1. Merancang dan mengeksekusi kegiatan internal yang meningkatkan kekompakan karyawan, seperti company outing, perayaan hari besar, atau program kesehatan mental (mental health awareness).\n 2. Menyelenggarakan survei kepuasan karyawan (Employee Engagement Survey), menganalisis hasilnya, dan menyusun rekomendasi perbaikan lingkungan kerja kepada manajemen.\n\n E. Manajemen Offboarding (proses keluar karyawan)\n 1. Memimpin sesi wawancara keluar (exit interview) untuk menggali alasan utama karyawan mengundurkan diri sebagai bahan evaluasi internal perusahaan.\n 2. Mengawal proses pengunduran diri atau PHK agar berjalan sesuai prosedur hukum, memastikan pemenuhan hak (seperti uang pisah atau pesangon), demi menjaga reputasi perusahaan (offboarding yang damai).",
    "qualification": "Kualifikasi\n 1. Pendidikan minimal S1 Hukum, Psikologi, Manajemen SDM, atau Komunikasi.\n 2. Pengalaman kerja Minimal 4–8 tahun di bidang Employee Engagement, Internal Communication, Culture, atau Human Capital.\n\nKompetensi\n1. Employee Engagement & Employee Experience.\n2. Internal Communication & Culture Development.\n3. Event & Program Management.\n4. Stakeholder Management & Communication.\n5. Employee Survey & Human Capital Analytics.\n6. Creativity & Continuous Improvement.\n\nSertifikasi\n1. Sertifikasi Human Capital atau Employee Engagement (menjadi nilai tambah).\n\nTraining\n1. Employee Engagement.\n2. Internal Communication.\n3. Culture Development.\n4. Employee Experience.\n5. Event Management.\n6. Human Capital Analytics.",
    "value_chain": "Platform Employee Engagement Survey & Program Budaya AKHLAK",
    "method_cost": 150000000.0
  },
  {
    "code": "1.A.2.2.3",
    "name": "Industrial Relation",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n \nA. Pengelolaan Hubungan Industrial\n1. Menyusun dan mengembangkan kebijakan hubungan industrial sesuai dengan regulasi ketenagakerjaan dan kebutuhan perusahaan.\n2. Mengelola hubungan kerja dengan karyawan, serikat pekerja, dan instansi ketenagakerjaan.\n3. Memberikan konsultasi kepada unit kerja terkait penerapan ketentuan hubungan industrial.\n4. Membangun hubungan industrial yang harmonis, dinamis, dan berkeadilan.\n\nB. Pengelolaan Kepatuhan Ketenagakerjaan\n1. Memastikan kepatuhan perusahaan terhadap peraturan ketenagakerjaan dan kebijakan internal.\n2. Mengelola penyusunan, pembaruan, dan implementasi Peraturan Perusahaan (PP) atau Perjanjian Kerja Bersama (PKB).\n3. Melaksanakan sosialisasi regulasi ketenagakerjaan kepada seluruh unit kerja.\n4. Memberikan rekomendasi penyelesaian permasalahan ketenagakerjaan sesuai ketentuan yang berlaku.\n\nC. Penyelesaian Perselisihan Hubungan Industrial\n1. Mengelola penyelesaian perselisihan hubungan industrial melalui mekanisme bipartit, mediasi, maupun proses sesuai ketentuan peraturan perundang-undangan.\n2. Mengoordinasikan penanganan kasus ketenagakerjaan bersama unit kerja terkait.\n3. Memberikan pendampingan dan rekomendasi dalam penyelesaian permasalahan hubungan industrial.\n4. Mengidentifikasi potensi risiko hubungan industrial sebagai upaya pencegahan konflik.\n\nD. Monitoring, Evaluasi, dan Pelaporan\n1. Melaksanakan monitoring dan evaluasi pelaksanaan hubungan industrial di lingkungan perusahaan.\n2. Menyusun laporan pelaksanaan hubungan industrial, kepatuhan ketenagakerjaan, dan penyelesaian kasus sebagai bahan evaluasi manajemen.\n3. Melakukan analisis terhadap tren hubungan industrial sebagai dasar penyusunan strategi perusahaan.",
    "qualification": "Kualifikasi\n1. Pendidikan Minimal S1 Hukum, Manajemen SDM, Psikologi, atau bidang terkait.\n2. Pengalaman Kerja Minimal 4–8 tahun di bidang Industrial Relations atau Human Capital.\n\nKompetensi\n1. Industrial Relations Management.\n2. Regulasi Ketenagakerjaan Indonesia.\n3. Negotiation & Conflict Resolution.\n4. Penyusunan Peraturan Perusahaan (PP) & PKB.\n5. Stakeholder Management & Communication.\n6. Problem Solving & Risk Management.\n\nSertifikasi\n1. Sertifikasi Hubungan Industrial atau Human Capital (BNSP).\n\nTraining\n1. Hubungan Industrial.\n2. Hukum Ketenagakerjaan.\n3. Teknik Negosiasi & Mediasi.\n4. Penyusunan PP & PKB.\n5. Manajemen Konflik.",
    "value_chain": "Framework Hubungan Industrial & Sistem Whistleblowing",
    "method_cost": 120000000.0
  },
  {
    "code": "1.A.2.3",
    "name": "HC GA & Operations",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n\nA. Perencanaan dan Pengelolaan Operasional Human Capital & General Affairs\n1. Menyusun strategi, kebijakan, dan rencana kerja operasional Human Capital dan General Affairs sesuai kebutuhan perusahaan.\n2. Mengoordinasikan pelaksanaan administrasi kepegawaian, layanan General Affairs, serta fasilitas operasional perusahaan.\n3. Mengendalikan pelaksanaan layanan HC & GA agar berjalan efektif, efisien, dan sesuai standar perusahaan.\n4. Memberikan rekomendasi kepada Direktur SDM terkait peningkatan kualitas layanan operasional SDM dan General Affairs.\n\nB. Pengelolaan Administrasi Kepegawaian dan Layanan General Affairs\n1. Mengarahkan pengelolaan administrasi kepegawaian, data karyawan, payroll support, serta layanan administrasi SDM lainnya.\n2. Mengendalikan pengelolaan aset perusahaan, fasilitas kerja, kendaraan operasional, perjalanan dinas, dan kebutuhan operasional kantor.\n3. Memastikan seluruh layanan HC & GA berjalan sesuai kebutuhan unit kerja dan ketentuan perusahaan.\n4. Mengoordinasikan pengelolaan vendor serta penyedia jasa pendukung operasional perusahaan.\n\nC. Pengelolaan Sarana, Prasarana, dan Layanan Operasional\n1. Mengendalikan pengelolaan fasilitas kerja, pemeliharaan gedung, aset perusahaan, serta sarana pendukung operasional.\n2. Memastikan ketersediaan fasilitas kerja dan pelayanan umum yang mendukung produktivitas karyawan.\n3. Mengembangkan sistem pelayanan HC & GA yang efektif dan berorientasi pada pelayanan internal.\n4. Melakukan koordinasi dengan unit kerja terkait kebutuhan operasional perusahaan.\n\nD. Monitoring, Evaluasi, dan Pelaporan HC & GA Operations\n1. Mengendalikan monitoring dan evaluasi pelaksanaan administrasi kepegawaian dan General Affairs.\n2. Menganalisis data operasional HC & GA sebagai dasar penyusunan rekomendasi kepada manajemen.\n3. Menyusun laporan pelaksanaan HC & GA Operations secara berkala.\n4. Mengembangkan perbaikan berkelanjutan terhadap proses dan layanan operasional.",
    "qualification": "Kualifikasi\n1. Pendidikan Minimal S1 Manajemen, Manajemen SDM, Administrasi Bisnis, Hukum, atau bidang terkait.\n2. Pengalaman Kerja Minimal 8 tahun di bidang Human Capital Operations atau General Affairs. Minimal 3 tahun pada posisi manajerial di bidang HC Operations, Personalia, atau General Affairs.\n\nKompetensi\n1. Human Capital Operations & General Affairs Management.\n2. Personnel Administration & HRIS.\n3. Asset, Facility & Vendor Management.\n4. Leadership, Communication & Stakeholder Management.\n5. Human Capital Analytics & Operational Planning.\n6. Regulasi Ketenagakerjaan, GCG, dan Tata Kelola Perusahaan.\n\nSertifikasi\n1. Sertifikasi Profesi Human Capital (BNSP/CHRP).\n2. Sertifikasi General Affairs atau Facility Management (menjadi nilai tambah).\n\nTraining\n1. Human Capital Operations Management.\n2. General Affairs & Facility Management.\n3. Asset & Vendor Management.\n4. Human Resource Information System (HRIS).\n5. Leadership Development.\n6. Good Corporate Governance (GCG).",
    "value_chain": "Sistem HRIS & Payroll Terintegrasi",
    "method_cost": 350000000.0
  },
  {
    "code": "1.A.2.3.1",
    "name": "Personalia",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n\nA.        Pengelolaan Penggajian dan Payroll\n1.        Melakukan evaluasi penggajian dan proses payroll, memastikan perhitungan gaji akurat dan tepat waktu.\n2.        Membuat rekapitulasi gaji untuk disampaikan kepada Divisi Keuangan.\n3.        Membuat perhitungan uang transport BKO sesuai absensi yang disampaikan dari Command Center.\n4.        Melakukan evaluasi perhitungan Tunjangan Hari Raya (THR) dan Jasa Produksi pegawai.\n5.        Membuat perhitungan pesangon dan kompensasi pegawai sesuai ketentuan yang berlaku.\n\nB.        Pengelolaan Kontrak, Database, dan Kepesertaan BPJS\n1.        Melakukan evaluasi dan monitoring atas pemutakhiran database pegawai setiap bulan.\n2.        Melakukan monitoring perpanjangan kontrak pegawai dan membuat form rekomendasi perpanjangan kontrak kepada user.\n3.        Menyusun Surat Perjanjian Kerja (SPK) pegawai untuk level VP ke atas beserta perpanjangannya.\n4.        Melakukan monitoring pendaftaran dan penonaktifan kepesertaan BPJS pegawai.\n5.        Melakukan perhitungan simulasi iuran Dana Pensiun Lembaga Keuangan (DPLK) setiap bulan.\n\nC.        Pelaporan dan Persiapan Data Manajemen\n1.        Membuat laporan bulanan, ragab, dan triwulan terkait kegiatan personalia.\n2.        Mempersiapkan data untuk kebutuhan perhitungan aktuaria.\n3.        Melakukan evaluasi biaya umum sebagai bagian dari pengendalian anggaran personalia.\n\nD.        Penyusunan Kebijakan dan Administrasi Kepegawaian\n1.        Mereview dan membuat Standard Operating Procedure (SOP) terkait operasional pegawai.\n2.        Menyusun Surat Keputusan (SK) Direksi terkait kepegawaian, termasuk rotasi, mutasi, dan penugasan.\n3.        Mendampingi pelaksanaan pemeriksaan BPJS apabila diperlukan.\n4.        Membuat surat penugasan dan surat peringatan pegawai sesuai arahan manajemen.\n\nE.        Pembinaan Staf Personalia\n1.        Membagi tugas kepada staf Personalia, memantau progres pekerjaan harian, dan mengevaluasi kinerja secara bulanan.\n\nF.        Koordinasi Internal dan Eksternal\n1.        Berkoordinasi dengan Divisi Operasi dan unit produksi terkait penggajian dan database pegawai proyek.\n2.        Berkoordinasi dengan Divisi Keuangan terkait pembayaran gaji pegawai, iuran DPLK, dan BPJS.\n3.        Berkoordinasi dengan bagian pajak terkait perhitungan pajak pegawai.\n4.        Berkoordinasi dengan Direktorat Strategi dan Pengembangan Bisnis terkait absensi tim BKO (Command Center) sebagai dasar perhitungan transport.\n5.        Berkoordinasi dengan BPJS terkait regulasi yang wajib dipenuhi perusahaan, serta dengan DPLK BRI terkait kebijakan dan regulasi manfaat pensiun.",
    "qualification": "Kualifikasi\n1.        Pendidikan Sarjana (S1)/sederajat semua jurusan.\n2.        Pengalaman kerja minimal 4-8 tahun dengan 2 tahun sebagai manager (project manager ataupun pada bidang lainnya)\n\nKompetensi\n1.        Pengelolaan Penggajian dan Payroll\n2.        Pengelolaan Kontrak, Database, dan Kepesertaan BPJS\n3.        Pelaporan dan Persiapan Data Manajemen\n4.        Penyusunan Kebijakan dan Administrasi Kepegawaian\n5.        Pembinaan Staf Personalia\n6.        Koordinasi Internal dan Eksternal\n7.        Pemahaman alur proses penggajian dan perhitungan Pajak Penghasilan (PPh 21).\n8.        Pemahaman peraturan ketenagakerjaan yang berlaku.\n9.        Kemampuan menganalisis data menggunakan Microsoft Excel.\n10.      Penguasaan ilmu manajemen yang relevan dengan pengelolaan operasional personalia.\n\nTraining\n1.        Penggajian dan Perhitungan Pajak Penghasilan Pegawai (PPh 21).\n2.        Pengelolaan Database dan Administrasi Kepegawaian.\n3.        Regulasi Ketenagakerjaan, BPJS, dan Dana Pensiun.",
    "value_chain": "Sistem Payroll, Database Pegawai, BPJS & DPLK",
    "method_cost": 250000000.0
  },
  {
    "code": "1.A.2.3.2",
    "name": "General Affairs",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n\nA. Perencanaan dan Pengelolaan General Affairs\n1. Menyusun rencana kerja dan program General Affairs sesuai kebutuhan operasional perusahaan.\n2. Mengelola kebutuhan fasilitas kerja, aset, dan sarana pendukung operasional perusahaan.\n3. Mengembangkan sistem pelayanan General Affairs yang efektif dan efisien.\n4. Berkoordinasi dengan unit kerja terkait kebutuhan operasional perusahaan.\n\nB. Pengelolaan Aset dan Fasilitas Perusahaan\n1. Mengelola aset perusahaan, gedung, kendaraan operasional, dan fasilitas kerja lainnya.\n2. Mengendalikan pemeliharaan sarana dan prasarana perusahaan agar selalu dalam kondisi baik.\n3. Mengelola inventaris aset serta administrasi pendukung General Affairs.\n4. Memastikan ketersediaan fasilitas kerja sesuai kebutuhan organisasi.\n\nC. Pengelolaan Layanan Operasional\n1. Mengelola pengadaan kebutuhan operasional kantor serta layanan umum perusahaan.\n2. Mengelola vendor, penyedia jasa, dan pihak ketiga yang mendukung operasional perusahaan.\n3. Mengoordinasikan perjalanan dinas, keamanan, kebersihan, dan pelayanan umum perusahaan.\n4. Memastikan seluruh layanan General Affairs berjalan secara efektif dan efisien.\n\nD. Monitoring, Evaluasi, dan Pelaporan\n1. Melaksanakan monitoring dan evaluasi terhadap pengelolaan aset dan layanan General Affairs.\n2. Menyusun laporan pelaksanaan General Affairs secara berkala.\n3. Mengembangkan perbaikan terhadap sistem pelayanan dan operasional General Affairs.",
    "qualification": "Kualifikasi\n1. Pendidikan Minimal S1 Manajemen, Administrasi Bisnis, Teknik Industri, atau bidang terkait.\n2. Pengalaman Kerja Minimal 4–8 tahun di bidang General Affairs atau Facility Management.\n\nKompetensi\n1. General Affairs & Facility Management.\n2. Asset & Inventory Management.\n3. Vendor & Procurement Management.\n4. Budget Planning & Cost Control.\n5. Communication & Stakeholder Management.\n6. K3, GCG, dan Tata Kelola Operasional.\n\nSertifikasi\n1. Sertifikasi General Affairs atau Facility Management.\n\nTraining\n1. General Affairs Management.\n2. Asset Management.\n3. Vendor Management.\n4. Facility Management.\n5. Basic Occupational Health & Safety (K3).\n6. Good Corporate Governance (GCG).",
    "value_chain": "SOP & Sistem Manajemen Aset/Fasilitas Kantor",
    "method_cost": 150000000.0
  },
  {
    "code": "1.A.3",
    "name": "Direktorat Pengadaan dan Logistik",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas:\nMerumuskan kebijakan, strategi, dan program kerja pengadaan, manajemen kontrak, rantai pasok, logistik, pergudangan, dan distribusi untuk mendukung kelancaran operasional dan pencapaian tujuan bisnis perusahaan.\n\nTanggung Jawab:\n1. Menyusun dan menetapkan strategi pengadaan dan logistik perusahaan.\n2. Memastikan ketersediaan barang, jasa, dan material secara tepat waktu, tepat mutu, dan tepat biaya.\n3. Mengelola rantai pasok secara terintegrasi dan efisien.\n4. Mengendalikan pelaksanaan pengadaan, logistik, pergudangan, dan distribusi.\n5. Memastikan kepatuhan terhadap ketentuan perusahaan, regulasi, dan prinsip tata kelola perusahaan yang baik (GCG).\n6. Mengoptimalkan biaya pengadaan dan logistik.\n7. Mengelola risiko operasional dalam proses pengadaan dan rantai pasok.\n8. Mengembangkan sistem dan proses pengadaan serta logistik yang berkelanjutan.",
    "qualification": "DIREKTORAT PENGADAAN DAN LOGISTIK\nPendidikan\n1. S1 Manajemen, Teknik Industri, Teknik Logistik, Supply Chain Management, Teknik Pertanian, Agribisnis, Manajemen Operasi, Akuntansi, atau bidang terkait.\n2. Diutamakan S2 Manajemen, Supply Chain Management, Logistik, Agribisnis, atau MBA.\n\nPengalaman\n1. Minimal 15 tahun pengalaman profesional.\n2. Minimal 8 tahun pada posisi manajerial di bidang pengadaan, supply chain, logistik, atau operasional.\n3. Berpengalaman mengelola rantai pasok berskala nasional.\n4. Diutamakan memiliki pengalaman di BUMN, industri pangan, agribisnis, FMCG, perdagangan komoditas, atau logistik.\n\nKompetensi Teknis\n1. Strategic Procurement Management.\n2. Supply Chain Management.\n3. Enterprise Risk Management.\n4. Contract Management.\n5. Inventory Management.\n6. Logistics Network Management.\n7. Corporate Governance dan Compliance.\n8. ERP/SAP Supply Chain Module.\n\nSertifikasi\n1. Certified Supply Chain Professional (CSCP) atau setara.\n2. Certified Procurement Professional (CPP) atau setara.\n3. Sertifikasi Manajemen Risiko.",
    "value_chain": "Framework Strategic Procurement & Supply Chain Governance",
    "method_cost": 300000000.0
  },
  {
    "code": "1.A.3.1",
    "name": "Procurment & Contract Management",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Procurement & Contract Management\nTugas:\nMengelola perencanaan, pelaksanaan, pengendalian pengadaan barang dan jasa serta pengelolaan kontrak untuk memenuhi kebutuhan perusahaan secara efektif dan efisien.\n\nTanggung Jawab:\n1. Menyusun strategi dan rencana pengadaan perusahaan.\n2. Mengelola proses pengadaan barang dan jasa.\n3. Mengendalikan pelaksanaan kontrak dengan penyedia.\n4. Melakukan evaluasi kinerja pemasok dan kontrak.\n5. Memastikan proses pengadaan berjalan sesuai kebijakan dan regulasi.\n6. Mengidentifikasi peluang efisiensi biaya dan peningkatan nilai tambah.",
    "qualification": "PROCUREMENT & CONTRACT MANAGEMENT\nPendidikan\n1. S1 Manajemen, Teknik Industri, Hukum, Akuntansi, Supply Chain Management, atau bidang terkait.\n2. Diutamakan S2 Manajemen atau Supply Chain.\n\nPengalaman\n1. Minimal 10 tahun di bidang pengadaan.\n2. Minimal 5 tahun pada posisi manajerial.\n3. Berpengalaman mengelola pengadaan strategis dan kontrak bernilai besar.\n\nKompetensi Teknis\n1. Strategic Procurement.\n2. Contract Administration.\n3. Tender Management.\n4. Procurement Planning.\n5. Cost Analysis.\n6. Vendor Management.\n7. Pengadaan BUMN dan GCG.\n\nSertifikasi\n1. Certified Procurement Professional (CPP).\n2. Certified Purchasing Manager (CPM).\n3. Sertifikasi PBJ Tingkat Lanjutan menjadi nilai tambah.",
    "value_chain": "Sistem e-Procurement (tender-evaluasi-kontrak)",
    "method_cost": 450000000.0
  },
  {
    "code": "1.A.3.1.1",
    "name": "Strategic sourcing and category management",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Strategic Sourcing and Category Management\nTugas:\nMenyusun strategi pengadaan berdasarkan kategori barang dan jasa untuk memperoleh nilai terbaik serta menjamin keberlanjutan pasokan.\n\nTanggung Jawab:\n1. Menyusun strategi sourcing berdasarkan kategori pengadaan.\n2. Melakukan analisis kebutuhan, pasar, dan pemasok.\n3. Mengembangkan strategi pengadaan jangka pendek dan jangka panjang.\n4. Melakukan segmentasi dan klasifikasi kategori pengadaan.\n5. Mengidentifikasi peluang efisiensi biaya dan peningkatan kualitas.\n6. Mengembangkan dan memelihara hubungan strategis dengan pemasok utama.\n7. Menyusun strategi mitigasi risiko pasokan.",
    "qualification": "STRATEGIC SOURCING AND CATEGORY MANAGEMENT\nPendidikan\n1. S1 Teknik Industri, Manajemen, Agribisnis, Supply Chain Management, Ekonomi, atau bidang terkait.\n\nPengalaman\n1. Minimal 8 tahun di bidang strategic sourcing atau category management.\n2. Memiliki pengalaman dalam pengadaan komoditas pangan dan bahan baku menjadi nilai tambah.\n\nKompetensi Teknis\n1. Strategic Sourcing.\n2. Category Management.\n3. Spend Analysis.\n4. Market Intelligence.\n5. Cost Modeling.\n6. Supplier Segmentation.\n7. Procurement Analytics.\n8. Commodity Market Analysis.\n\nSertifikasi\n1. Certified Strategic Sourcing Professional.\n2. CPP atau CPSM menjadi nilai tambah.\n\nKompetensi Khusus\n1. Kemampuan melakukan analisis harga komoditas pangan nasional dan global.\n2. Kemampuan menyusun strategi sourcing jangka panjang.",
    "value_chain": "Metodologi Strategic Sourcing & Category Management (spend analysis), Strategic Sourcing System, Commodity Intelligence System",
    "method_cost": 9200000000.0
  },
  {
    "code": "1.A.3.1.2",
    "name": "Procurment execution",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Procurement Execution\nTugas:\nMelaksanakan seluruh proses pengadaan barang dan jasa sesuai kebutuhan perusahaan dan ketentuan yang berlaku.\n\nTanggung Jawab:\n1. Menyusun dan melaksanakan rencana pengadaan.\n2. Melakukan proses tender, seleksi, negosiasi, dan penetapan penyedia.\n3. Memastikan ketepatan waktu pelaksanaan pengadaan.\n4. Mengelola administrasi dan dokumentasi pengadaan.\n5. Memastikan kepatuhan terhadap prosedur pengadaan perusahaan.\n6. Melakukan monitoring realisasi pengadaan terhadap rencana kebutuhan.\n7. Menyusun laporan pelaksanaan pengadaan.",
    "qualification": "PROCUREMENT EXECUTION\nPendidikan\n1. S1 Manajemen, Teknik Industri, Akuntansi, Hukum, atau bidang terkait.\n\nPengalaman\n1. Minimal 7 tahun di bidang pengadaan.\n2. Berpengalaman menangani tender dan kontrak pengadaan.\n\nKompetensi Teknis\n1. Tender Management.\n2. E-Procurement.\n3. Procurement Administration.\n4. Negotiation Management.\n5. Vendor Evaluation.\n6. Contract Documentation.\n\nSertifikasi\n1. Certified Procurement Professional.\n2. Sertifikasi Pengadaan Barang/Jasa.\n\nKompetensi Khusus\n1. Kemampuan menyusun dokumen tender.\n2. Kemampuan negosiasi harga dan syarat kontrak.\n3. Pemahaman regulasi pengadaan BUMN.",
    "value_chain": "SOP Tender, Seleksi, dan Negosiasi Penyedia",
    "method_cost": 150000000.0
  },
  {
    "code": "1.A.3.1.3",
    "name": "Vendor and contract management",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Vendor and Contract Management\nTugas:\nMengelola hubungan dengan pemasok serta memastikan pengelolaan kontrak berjalan efektif dan memberikan manfaat optimal bagi perusahaan.\n\nTanggung Jawab:\n1. Mengelola proses registrasi dan evaluasi vendor.\n2. Memelihara database vendor yang akurat dan terkini.\n3. Menyusun, mengelola, dan memonitor pelaksanaan kontrak.\n4. Melakukan penilaian kinerja vendor secara berkala.\n5. Menangani permasalahan dan sengketa kontrak.\n6. Memastikan pemenuhan hak dan kewajiban para pihak dalam kontrak.\n7. Menyusun rekomendasi perpanjangan, perubahan, atau penghentian kontrak.",
    "qualification": "VENDOR AND CONTRACT MANAGEMENT\nPendidikan\n1. S1 Hukum, Manajemen, Teknik Industri, Akuntansi, atau bidang terkait.\n\nPengalaman\n1. Minimal 7 tahun di bidang vendor management atau contract management.\n2. Memiliki pengalaman menangani kontrak komersial dan operasional.\n\nKompetensi Teknis\n1. Contract Lifecycle Management.\n2. Vendor Performance Management.\n3. Supplier Relationship Management.\n4. Contract Negotiation.\n5. Contract Risk Management.\n6. Legal Drafting.\n\nSertifikasi\n1. Certified Contract Management Professional.\n2. Certified Procurement Professional.\n\nKompetensi Khusus\n1. Kemampuan menyusun dan mereviu kontrak bisnis.\n2. Kemampuan mengelola hubungan dengan vendor strategis.",
    "value_chain": "Sistem Vendor Management & Contract Lifecycle Management, Supplier Qualification Program, Vendor Performance Management",
    "method_cost": 22200000000.0
  },
  {
    "code": "1.A.3.2",
    "name": "Supply Chain & Logostik",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Supply Chain & Logistics\nTugas:\nMengelola perencanaan pasokan, logistik, pergudangan, dan distribusi untuk menjamin kelancaran arus barang dari sumber hingga pengguna akhir.\n\nTanggung Jawab:\n1. Menyusun strategi rantai pasok dan logistik perusahaan.\n2. Mengintegrasikan proses perencanaan, pengadaan, penyimpanan, dan distribusi.\n3. Mengendalikan ketersediaan persediaan dan kapasitas logistik.\n4. Memastikan efisiensi biaya dan efektivitas operasional rantai pasok.\n5. Mengelola risiko rantai pasok dan distribusi.\n6. Memastikan kelancaran operasional logistik dan pergudangan.",
    "qualification": "SUPPLY CHAIN & LOGISTICS\nPendidikan\n1. S1 Teknik Industri, Teknik Logistik, Agribisnis, Manajemen Operasi, atau bidang terkait.\n2. Diutamakan S2 Supply Chain atau Logistik.\n\nPengalaman\n1. Minimal 10 tahun di bidang supply chain.\n2. Minimal 5 tahun pada posisi manajerial.\n\nKompetensi Teknis\n1. Supply Chain Management.\n2. Logistics Network Planning.\n3. Inventory Management.\n4. Distribution Management.\n5. Demand Planning.\n6. Warehouse Management.\n\nSertifikasi\n1. CSCP (Certified Supply Chain Professional).\n2. CLTD (Certified in Logistics, Transportation and Distribution).\n\nKompetensi Khusus\n1. Pengelolaan rantai pasok pangan nasional.\n2. Perencanaan distribusi komoditas skala besar.",
    "value_chain": "Framework Integrated Supply Chain Management",
    "method_cost": 350000000.0
  },
  {
    "code": "1.A.3.2.1",
    "name": "Supply planning and Inventory",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Supply Planning and Inventory\nTugas:\nMerencanakan kebutuhan pasokan dan mengelola persediaan untuk menjamin ketersediaan barang secara optimal.\n\nTanggung Jawab:\n1. Menyusun perencanaan kebutuhan material dan barang.\n2. Melakukan forecasting permintaan dan kebutuhan operasional.\n3. Menetapkan tingkat persediaan minimum, maksimum, dan safety stock.\n4. Mengendalikan tingkat persediaan untuk menghindari stock-out dan overstock.\n5. Melakukan monitoring inventory turnover dan aging stock.\n6. Menyusun laporan persediaan dan kebutuhan pasokan.\n7. Mengoptimalkan nilai persediaan perusahaan.",
    "qualification": "SUPPLY PLANNING AND INVENTORY\nPendidikan\n1. S1 Teknik Industri, Statistika, Matematika, Agribisnis, Supply Chain Management, atau bidang terkait.\n\nPengalaman\n1. Minimal 7 tahun di bidang demand planning, inventory planning, atau supply planning.\n\nKompetensi Teknis\n1. Demand Forecasting.\n2. Supply Planning.\n3. Inventory Optimization.\n4. Material Requirement Planning (MRP).\n5. Sales and Operations Planning (S&OP).\n6. Data Analytics.\n\nSertifikasi\n1. CPIM (Certified in Planning and Inventory Management).\n2. CSCP menjadi nilai tambah.\n\nKompetensi Khusus\n1. Kemampuan forecasting kebutuhan pangan.\n2. Kemampuan mengelola stok komoditas dengan tingkat volatilitas tinggi.",
    "value_chain": "Sistem Demand Forecasting & Inventory Optimization (S&OP)",
    "method_cost": 300000000.0
  },
  {
    "code": "1.A.3.2.2",
    "name": "Logistik and operation",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Logistics and Operations\nTugas:\nMengelola operasional logistik untuk memastikan kelancaran arus barang dan efisiensi biaya distribusi.\n\nTanggung Jawab:\n1. Mengelola kegiatan transportasi dan pengiriman barang.\n2. Mengatur pergerakan barang dari pemasok ke fasilitas perusahaan dan pelanggan.\n3. Mengoptimalkan rute, moda transportasi, dan biaya logistik.\n4. Mengelola penyedia jasa logistik dan transportasi.\n5. Memastikan ketepatan waktu pengiriman dan penerimaan barang.\n6. Mengendalikan risiko operasional logistik.\n7. Menyusun laporan kinerja logistik dan distribusi.",
    "qualification": "LOGISTICS AND OPERATION\nPendidikan\n1. S1 Teknik Logistik, Teknik Industri, Manajemen Transportasi, atau bidang terkait.\n\nPengalaman\n1. Minimal 7 tahun di bidang logistik dan transportasi.\n2. Berpengalaman mengelola distribusi nasional.\n\nKompetensi Teknis\n1. Transportation Management.\n2. Route Optimization.\n3. Logistics Cost Analysis.\n4. Freight Management.\n5. Fleet Management.\n6. Distribution Operations.\n\nSertifikasi\n1. Certified Logistics Professional.\n2. CLTD menjadi nilai tambah.\n\nKompetensi Khusus\n1. Pengelolaan logistik multimoda.\n2. Pengendalian biaya distribusi komoditas pangan.",
    "value_chain": "Sistem Transportation Management System (TMS) & Route Optimization, Transportation Management System, Fleet Management System",
    "method_cost": 40350000000.0
  },
  {
    "code": "1.A.3.2.3",
    "name": "warehouse and distribution",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Warehouse and Distribution\nTugas:\nMengelola kegiatan pergudangan dan distribusi barang untuk menjamin akurasi persediaan, kualitas barang, dan kelancaran distribusi.\n\nTanggung Jawab:\n1. Mengelola penerimaan, penyimpanan, dan pengeluaran barang di gudang.\n2. Menjaga akurasi data stok dan administrasi pergudangan.\n3. Melaksanakan stock opname dan rekonsiliasi persediaan secara berkala.\n4. Menjaga kualitas, keamanan, dan kondisi barang selama penyimpanan.\n5. Mengelola distribusi barang ke unit kerja, pelanggan, atau mitra.\n6. Mengoptimalkan kapasitas dan tata letak gudang.\n7. Memastikan penerapan standar K3, keamanan, dan ketertelusuran barang.\n8. Menyusun laporan kinerja pergudangan dan distribusi.",
    "qualification": "WAREHOUSE AND DISTRIBUTION\nPendidikan\n1. S1 Teknik Industri, Logistik, Manajemen Operasi, Agribisnis, atau bidang terkait.\n\nPengalaman\n1. Minimal 7 tahun di bidang pergudangan dan distribusi.\n2. Berpengalaman mengelola gudang skala besar dan distribusi multiwilayah.\n\nKompetensi Teknis\n1. Warehouse Management System (WMS).\n2. Inventory Control.\n3. Distribution Management.\n4. Warehouse Layout & Capacity Planning.\n5. FIFO/FEFO Management.\n6. Stock Accuracy Management.\n\nSertifikasi\n1. Certified Warehouse Management Professional.\n2. Sertifikasi K3 menjadi nilai tambah.\n\nKompetensi Khusus\n1. Pengelolaan gudang komoditas pangan.\n2. Pemahaman cold chain dan food handling menjadi nilai tambah.\n3. Kemampuan mengelola distribusi hingga tingkat regional dan cabang.",
    "value_chain": "Sistem Warehouse Management System (WMS) FIFO/FEFO, Distribution Center Nasional, Cold Storage Warehouse, Warehouse Management System",
    "method_cost": 178400000000.0
  },
  {
    "code": "1.B",
    "name": "Wakil Direktur Utama II",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas\n\n- Mengoordinasikan fungsi-fungsi yang bersifat operasional dan revenue-generating: rantai bisnis inti pangan (produksi-pengolahan), retail-distribusi, keuangan-risiko, teknik-enjiniring, serta fungsi pendukung operasional (Business Support)\n\nTanggung Jawab\n\n-  Akuntabel ke Dirut atas kinerja operasional dan finansial korporat end-to-end — dari produksi pangan sampai ke retail/distribusi ke konsumen\n- Memastikan sinergi antar direktorat inti bisnis (mis. output produksi Pangan selaras dengan kapasitas distribusi Retail)\n- Mengawasi kesehatan keuangan dan manajemen risiko korporat",
    "qualification": "Kualifikasi\n\nS2 manajemen/agribisnis/keuangan, pengalaman 15-18 tahun termasuk minimal 5-7 tahun di posisi direksi/senior eksekutif, idealnya punya pengalaman P&L end-to-end di sektor pangan/retail/manufaktur\n\nKompetensi Teknis\n\nOperations management skala besar, financial management & risk oversight, supply chain pangan-ke-retail, engineering project oversight\n\nSertifikasi\n\nTidak wajib; nilai tambah: sertifikasi manajemen risiko korporat (CRMP) mengingat langsung membawahi Direktur Keuangan dan Manajemen Risiko",
    "value_chain": "Sistem Corporate Performance Dashboard (sinergi operasional-finansial end-to-end)",
    "method_cost": 350000000.0
  },
  {
    "code": "1.B.1",
    "name": "Direktur Business Support",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas\n\n- Mengoordinasikan fungsi pendukung korporat lintas wilayah (regional affairs)\n- Memastikan tata kelola QSHE berjalan di seluruh unit operasional\n- Mendorong perbaikan proses bisnis berkelanjutan di level korporat\n\nTanggung Jawab\n\n- Akuntabel ke Wakil Dirut II atas efektivitas fungsi support\n- Memastikan tidak ada gap governance QSHE yang berujung insiden/temuan audit\n- Memastikan inisiatif BPI terintegrasi dengan strategi korporat (bukan berjalan sendiri-sendiri)",
    "qualification": "Kualifikasi\n\nS1/S2 manajemen/teknik/agribisnis, pengalaman 12-15 tahun termasuk minimal 5 tahun di posisi manajerial senior di BUMN/korporasi besar, idealnya pernah pegang fungsi operasional daerah dan fungsi QSHE/proses bisnis\n\nKompetensi Teknis\n\nBusiness process management, stakeholder management multi-level (pusat-daerah), risk & safety governance, change management\n\nSertifikasi\n\nUmumnya tidak wajib punya sertifikasi teknis spesifik di level direktur — yang relevan: sertifikasi manajemen risiko (misal CRMP) atau leadership BUMN (jika ada program AAP/sertifikasi Kementerian BUMN)",
    "value_chain": "Framework Business Support & QSHE Governance Korporat",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.1.1",
    "name": "Corporate - Regional Affairs and Coordination",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas\n\n- Menjembatani komunikasi dan koordinasi antara kantor pusat dengan operasional di daerah\n- Mengelola hubungan dengan stakeholder eksternal (pemda, komunitas)\n\nTanggung Jawab\n\n- Memastikan kebijakan pusat tersampaikan dan terimplementasi konsisten di daerah\n- Menjaga hubungan baik dengan pemangku kepentingan lokal agar operasional tidak terganggu isu sosial/politik",
    "qualification": "Kualifikasi\n\nS1, pengalaman 8-10 tahun di government/public relations atau regional operations, familiar dengan struktur pemerintahan daerah\n\nKompetensi Teknis\n\nGovernment relations, community engagement, conflict resolution, coordination lintas fungsi\n\nSertifikasi\n\nTidak ada sertifikasi wajib standar industri; sertifikasi CSR/community development bisa jadi nilai tambah, bukan syarat mutlak",
    "value_chain": "Sistem Koordinasi & Pelaporan Regional (regional dashboard)",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.1.1.1",
    "name": "Regional Coordination",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas\n\n- Koordinasi operasional harian dengan 6 Direktur Wilayah (Sumatera, Sulawesi, Maluku Papua, Kalimantan, Jawa, Bali Nusra)\n\nTanggung Jawab\n\n- Memastikan reporting dan eskalasi isu dari wilayah ke pusat berjalan lancar",
    "qualification": "Kualifikasi\n\nS1, 6-8 tahun pengalaman koordinasi multi-region\n\nKompetensi Teknis\n\nRegional operations monitoring, reporting system\n\nSertifikasi\n\nTidak ada yang wajib",
    "value_chain": "SOP Koordinasi Operasional 6 Direktur Wilayah",
    "method_cost": 150000000.0
  },
  {
    "code": "1.B.1.1.2",
    "name": "Stakeholder and Community Relations",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas\n\n- Mengelola hubungan sosial dengan warga/komunitas umum di sekitar area operasional lintas seluruh lini bisnis (bukan spesifik petani binaan atau media/korporat) — mencakup sosialisasi program, penanganan aspirasi/keluhan warga, dan menjaga hubungan baik dengan tokoh masyarakat setempat\n\nTanggung Jawab\n\n- Menjaga social license to operate di level komunitas umum untuk seluruh unit bisnis (Pangan, Retail, Teknik, dst) secara terpadu\n- Menjadi titik kontak sosial tunggal ke warga agar tidak terjadi pendekatan berbeda-beda dari tiap lini bisnis ke komunitas yang sama\n- Mediasi konflik sosial non-teknis (di luar isu spesifik pertanian/peternakan yang jadi ranah Farmer Engagement)",
    "qualification": "Kualifikasi\n\nS1, 6-8 tahun pengalaman di community relations/social development, idealnya pernah menangani multi-stakeholder di area operasional industri ekstraktif/agribisnis/infrastruktur skala besar\n\nKompetensi Teknis\n\nCommunity engagement, pemetaan sosial (social mapping), negosiasi dan resolusi konflik, koordinasi lintas-fungsi (karena harus sinkron dengan tiap direktorat bisnis)\n\nSertifikasi\n\nTidak wajib secara regulasi; sertifikasi social impact assessment atau community development jadi nilai tambah",
    "value_chain": "Metodologi Social Mapping & Community Engagement",
    "method_cost": 180000000.0
  },
  {
    "code": "1.B.1.2",
    "name": "QSHE (Quality, Safety, Health and Environment) Governance and Assurance",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas\n\n- Menyusun kebijakan dan standar Quality, Safety, Health, Environment;\n- Melakukan assurance/audit kepatuhan QSHE di seluruh unit operasional\n\nTanggung Jawab\n\n- Memastikan kepatuhan terhadap regulasi K3L (UU No.1/1970, PP 50/2012 SMK3, dll)\n- Menjadi eskalasi utama saat ada insiden safety/lingkungan",
    "qualification": "Kualifikasi\n\nS1 Teknik/K3/Lingkungan, pengalaman 8-10 tahun di fungsi QSHE, idealnya di sektor manufaktur/agribisnis/konstruksi yang punya risiko K3 tinggi\n\nKompetensi Teknis\n\nSMK3, ISO 45001 (K3), ISO 14001 (lingkungan), ISO 9001 (mutu), risk assessment\n\nSertifikasi\n\nSertifikasi memang wajib secara regulasi: Ahli K3 Umum (Kemnaker), auditor SMK3, ISO 9001/14001/45001 Lead Auditor",
    "value_chain": "Sertifikasi & Audit ISO 45001 + ISO 14001 + SMK3",
    "method_cost": 350000000.0
  },
  {
    "code": "1.B.1.3",
    "name": "Business Process Improvement",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas\n\n- Identifikasi inefisiensi proses bisnis\n- Merancang dan mengawal implementasi perbaikan proses\n\nTanggung Jawab\n\n- Memastikan proses bisnis terstandardisasi dan terukur (SOP, KPI proses)\n- Reduksi waste/cost",
    "qualification": "Kualifikasi\n\nS1/S2, pengalaman 6-10 tahun di business process/continuous improvement, idealnya pernah di consulting atau internal PMO\n\nKompetensi Teknis\n\nProcess mapping, Lean Six Sigma, business process reengineering, analisis data operasional, change management.\n\nSertifikasi\n\nLean Six Sigma (Green/Black Belt), Business Process Management (BPM) certification — nilai tambah kuat, meski tidak selalu jadi syarat mutlak",
    "value_chain": "Metodologi Lean Six Sigma & Business Process Reengineering",
    "method_cost": 350000000.0
  },
  {
    "code": "1.B.2",
    "name": "Direktur Pangan",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Bertanggung jawab memimpin, merumuskan kebijakan, dan mengendalikan seluruh aktivitas bisnis pangan di PT Agrinas Pangan Nusantara (Persero), mencakup hulu hingga hilir: mulai dari pengembangan kawasan sentra produksi pangan (KSPP), pengadaan, pengelolaan pasca-panen, hingga komersialisasi dan distribusi untuk memastikan kedaulatan pangan nasional sekaligus menghasilkan profitabilitas perusahaan yang berkelanjutan.\n\nTugas & Tanggung Jawab\n1. Pengembangan Sentra Produksi & Pertanian Modern (Hulu)\nPengembangan Wilayah Produksi: Memimpin strategi perluasan dan optimalisasi lahan pertanian/perkebunan mandiri atau kemitraan untuk komoditas strategis (padi, jagung, singkong, dll).\n\n\n2. Pengelolaan Rantai Pasok & Infrastruktur Pasca-Panen (Tengah)\nKemitraan strategis (Off-Taker): Membangun ekosistem inklusif dengan petani lokal, koperasi, dan kelompok tani sebagai penyerap hasil panen (off-taker) utama demi menjaga stabilitas harga di tingkat produsen, mengawasi standardisasi operasional pengolahan hasil panen (pabrik penggilingan, pengeringan/RMU, pengolahan pakan) guna menjaga kualitas produk pangan sesuai standar pasar dan regulasi, dan memastikan keandalan sistem pergudangan, cold chain system, dan transportasi untuk meminimalkan food loss selama distribusi.\n\n3. Komersialisasi, Distribusi, & Penetrasi Pasar (Hilir)\nMengembangkan saluran distribusi pangan untuk pasar korporasi (B2B), pemenuhan kebutuhan lembaga negara/TNI/Polri, serta penetrasi ke pasar ritel modern dan digital (B2C) serta Menginisiasi hilirisasi produk pangan mentah menjadi produk pangan olahan bermerek (branded) untuk meningkatkan margin keuntungan perusahaan.\n\n4. Eksekusi Penugasan Ketahanan Pangan Pemerintah\nMengkoordinasikan aksi korporasi dalam rangka mendukung operasi pasar atau intervensi harga saat terjadi gejolak pasar atau kelangkaan pangan pokok nasional dan Manajemen Cadangan Pangan Nasional: Mengelola volume stok cadangan pemerintah secara akurat, aman, dan berkualitas tinggi agar siap disalurkan dalam kondisi darurat.\n\n5. Hubungan Kelembagaan & Sinergi BUMN\nMenjalin kerja sama taktis dengan BUMN Pangan lain (seperti ID FOOD, Perum Bulog), Kementerian BUMN, Kementerian Pertanian, serta pemerintah daerah.",
    "qualification": "Kualifikasi:\nMinimal S2/S3 lebih diutamakan di bidang Agribisnis, Agronomi, Teknologi Pangan, Teknik Industri, Manajemen Bisnis/MBA, atau bidang relevan lainnya dari universitas dengan reputasi tinggi.\n\nKeahlian dan Sertifikasi:\n1. Minimal 10–15 tahun pengalaman di industri agribisnis, Fast-Moving Consumer Goods (FMCG) sektor pangan, atau manajemen rantai pasok dan Minimal 5 tahun pengalaman pada level eksekutif/manajemen senior (seperti Direktur, Vice President, atau General Manager) dengan rekam jejak terbukti dalam memimpin organisasi skala besar atau mengelola pendapatan (Revenue/P&L) triliunan rupiah.\n2. Memenuhi syarat formulir fit and proper test Kementerian BUMN (tidak pernah pailit, bebas dari catatan pidana/korupsi, dan memiliki integritas moral yang tinggi);\n3. Sertifikasi Tata Kelola & Manajemen Risiko (Wajib/Sangat Diutamakan untuk BUMN);\n4. Sertifikasi Strategi & Rantai Pasok;\n5. Sertifikasi Mutu & Keamanan Pangan Nasional : Sertifikasi Pemahaman Standar ISO (ISO 22000 / ISO 9001).",
    "value_chain": "Framework Manajemen Rantai Pangan Hulu-Hilir & Ketahanan Pangan Nasional",
    "method_cost": 400000000.0
  },
  {
    "code": "1.B.2.1",
    "name": "KSPP",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Bertanggung jawab penuh atas seluruh aspek manajemen di KSPP, mulai dari kinerja profitabilitas (P&L - Profit and Loss), kelancaran operasional harian hulu-hilir, hubungan kelembagaan dengan pemerintah daerah/tokoh masyarakat, hingga keselamatan dan produktivitas seluruh aset serta SDM di kawasan tersebut. Posisi ini melaporkan kinerjanya langsung kepada Direktur Pangan.\n\nTugas & Tanggung Jawab:\n1. Kepemimpinan Strategis & Pengelolaan P&L Kawasan\nBertanggung jawab atas pencapaian target pendapatan, efisiensi biaya operasional (OpEx), dan profitabilitas keseluruhan dari site KSPP yang dipimpin dan Menerjemahkan visi dan target dari manajemen pusat PT Agrinas ke dalam rencana aksi konkret di tingkat kawasan per musim tanam/tahunan.\n\n2. Integrasi & Supervisi Lintas Fungsi di Kawasan\nMemastikan tim Crop Production (tanaman) dan Livestock Management (peternakan) berjalan selaras dengan konsep pertanian sirkular, serta didukung penuh oleh tim Operations dan Development dan Memimpin rapat evaluasi berkala bersama tim Planning and Operation Control (POC) untuk memantau varians target, realisasi anggaran, dan segera mengambil tindakan korektif jika terjadi deviasi di lapangan.\n\n3. Pengelolaan Hubungan Strategis Pemangku Kepentingan (Stakeholder)\nMenjadi perwakilan resmi PT Agrinas di tingkat regional untuk berkoordinasi dengan Dinas Pertanian/Peternakan, Kepolisian, Koramil, dan Bupati/Aparat Daerah setempat dan Mendukung tim Farmer & Breeder Engagement dalam membina hubungan harmonis dengan masyarakat adat, pemilik lahan, dan serikat pekerja lokal guna mencegah konflik sosial yang dapat menghentikan operasional kawasan.\n\n4. Manajemen Aset, GCG, dan K3\nMemastikan seluruh aset BUMN yang berada di kawasan (lahan, mesin pabrik, kendaraan, inventaris stok) terjaga dengan aman dan dikelola sesuai prinsip Good Corporate Governance (GCG) dan Menjamin terciptanya lingkungan kerja yang aman dan sehat bagi seluruh karyawan, buruh harian, dan mitra petani di dalam kawasan.",
    "qualification": "Kualifikasi:\nMinimal S1 (S2 diutamakan) di bidang Agribisnis, Agronomi, Ilmu Tanah, Teknik Pertanian, Manajemen Bisnis, atau Teknik Industri. Minimal 5–8 tahun pengalaman di industri agribisnis, perkebunan, peternakan skala industri, atau manajemen proyek lapangan. Minimal 3 tahun pengalaman pada posisi manajerial (seperti Estate Manager, Farm Manager, atau Project Manager) yang memimpin minimal 20-50 staf/pekerja di lapangan.\n\nKeahlian dan Sertifikasi:\n1. Keahlian Kepemimpinan & Bisnis (Leadership & Business Skills);\n2. Keahlian Hubungan Kelembagaan & Sosial (Stakeholder Management);\n3. Keahlian Teknis Integrasi (Agro-Industrial Skills);\n4. Sertifikasi Manajemen Proyek & Risiko;\n5. Sertifikasi Manajemen Operasional & Mutu Industri : Sertifikasi Manajer Agribisnis / Pengelola Kebun (BNSP) dan/ Sertifikasi ISO 9001 (Manajemen Mutu) & ISO 22000 (Keamanan Pangan)\n6. Sertifikasi Ahli K3 Umum (Kemnaker)",
    "value_chain": "Framework P&L & Governance Multi-Site KSPP",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.2.1.1",
    "name": "KSPP Development",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Mengembangkan kawasan produksi baru berbasis perencanaan spasial, kesesuaian lahan, dan infrastruktur dasar. Peran ini mengombinasikan kemampuan manajemen proyek (project management), negosiasi pembebasan/konsolidasi lahan, penerapan teknologi pertanian (agritech), hingga memastikan hasil panen terserap 100% oleh rantai pasok hilir perusahaan.\n\nTugas & Tanggung Jawab:\n1. Perencanaan & Kelayakan Kawasan (Feasibility & Planning)\nMelakukan survei dan studi kelayakan (kesuburan tanah, ketersediaan air, dan akses logistik) sebelum menetapkan suatu wilayah menjadi KSPP dan Merancang tata letak (layout) kawasan yang mengintegrasikan zona budidaya, zona pemrosesan (pabrik/RMU), zona gudang/silo, dan jalur transportasi logistik.\n\n2. Konsolidasi Lahan & Kemitraan Petani (Social Engineering)\nMelakukan negosiasi dan kerja sama dengan pemerintah daerah, pemilik lahan, atau kelompok tani untuk menyatukan lahan-lahan kecil menjadi satu kawasan skala industri (land consolidation) dan menjadi jembatan antara PT Agrinas dengan komunitas petani lokal, mengedukasi mereka mengenai sistem korporatisasi pertanian dan bagi hasil yang adil.\n\n3. Eksekusi Infrastruktur & Mekanisasi (Konstruksi & Teknis)\nMengawal jalannya pembangunan infrastruktur pendukung KSPP, seperti jaringan irigasi modern (pari-pari/tetes), jalan usaha tani, gedung pasca-panen, dan pemasangan alat mesin pertanian (alsintan) dan mengintegrasikan teknologi pertanian modern (smart farming) di lapangan, seperti sensor cuaca, otomatisasi pemupukan, dan penggunaan drone untuk pemetaan lahan.\n\n4. Manajemen Operasional Produksi & Pasca-Panen (Hulu-Tengah)\nMemastikan seluruh proses budidaya (jadwal tanam, pemilihan benih unggul, pemeliharaan) mengikuti standar Good Agricultural Practices (GAP) perusahaan untuk mencapai target tonase dan mengawasi operasional saat panen tiba untuk memastikan gabah/hasil komoditas langsung masuk ke unit pengeringan (drier) atau penggilingan guna menekan angka kerusakan (loss).\n\n5. Koordinasi Hilirisasi & Logistik\nBerkoordinasi dengan tim Logistik dan Pemasaran pusat PT APN agar hasil produksi KSPP siap diangkut dan didistribusikan ke konsumen atau jaringan ritel sesuai jadwal penyerapan.",
    "qualification": "Kualifikasi :\nMinimal S1 (S2 diutamakan) di bidang Teknik Sipil, Teknik Agrosistem/Pertanian, Perencanaan Wilayah dan Kota (Planologi), Agribisnis, atau Manajemen Proyek. Level Manager / Head: Minimal 5–8 tahun pengalaman dalam memimpin proyek berskala besar (Mega Project/Food Estate), akuisisi lahan skala industri, atau pembangunan infrastruktur agro, dengan minimal 3 tahun di posisi pimpinan tim (Project Manager).\n\nKeahlian dan Sertifikasi:\n1. Keahlian Manajemen Proyek & Infrastruktur (Project & Infrastructure Excellence);\n2. Keahlian Hukum Pertanahan & Hubungan Masyarakat;\n3. Sertifikasi Manajemen Proyek (Sangat Diutamakan);\n4. Sertifikasi Manajemen Risiko & Pengadaan (Wajib untuk Level Manager);",
    "value_chain": "Studi Kelayakan & Land Suitability Analysis (GIS/CAD) per kawasan",
    "method_cost": 150000000.0
  },
  {
    "code": "1.B.2.1.2",
    "name": "KSPP Operations",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Memimpin, mengawasi, dan mengoptimalkan seluruh aktivitas operasional harian di dalam kawasan sentra produksi pangan. Fokus utamanya adalah memastikan seluruh mata rantai di dalam kawasan—mulai dari jadwal tanam, perawatan, proses panen, pengolahan pasca-panen (pabrik/RMU), hingga pengiriman barang ke gudang pusat—berjalan secara efektif, efisien, aman, dan memenuhi standar kualitas pangan yang ketat.\n\nTugas & Tanggung Jawab:\n1. Manajemen Budidaya & Produksi Harian (Hulu)\nMengatur dan mengawasi implementasi kalender tanam para petani/pekerja di kawasan KSPP guna memastikan kontinuitas pasokan pangan (menghindari penumpukan atau kekosongan panen), mengontrol distribusi dan penggunaan benih, pupuk, serta pestisida di lapangan agar tepat waktu, tepat dosis, dan efisien secara biaya, dan mengelola utilitas alat mesin pertanian (alsintan) seperti traktor, drone, dan combine harvester agar selalu dalam kondisi siap pakai (high availability).\n\n2. Operasional Pasca-Panen & Industrialisasi (Tengah)\nManajemen Pabrik Pengolahan: Memimpin operasional fasilitas pasca-panen di dalam kawasan, seperti Rice Milling Unit (RMU), corn dryer, atau gudang pendingin (cold storage), memastikan produk pangan yang diproses di KSPP memenuhi standar kualitas (kadar air, kebersihan, ukuran) sebelum dikemas dan didistribusikan, dan menyusun jadwal perawatan berkala (preventive maintenance) untuk seluruh mesin produksi di kawasan guna menghindari downtime (macet produksi).\n\n3. Logistik Kawasan & Manajemen Gudang (Inventory)\nMengatur keluar-masuknya barang (FIFO/FEFO) di gudang kawasan dan menjaga akurasi data stok komoditas dan menerapkan prosedur ketat untuk menekan angka kehilangan pangan (food loss) saat proses pemanenan, pengeringan, dan penyimpanan di gudang.\n\n4. Manajemen Tenaga Kerja Lapangan & Keselamatan Kerja\nMengkoordinasikan para Mandor, Penyuluh Pertanian Lapangan (PPL), dan kelompok tani binaan dalam aktivitas operasional harian dan memastikan seluruh pekerja di area ladang maupun pabrik pengolahan menerapkan standar keselamatan kerja dan higienitas pangan.",
    "qualification": "Kualifikasi :\nMinimal S1 (S2 diutamakan) di bidang Teknik Mesin, Teknik Elektro, Teknik Industri, Teknologi Pangan/Pasca-Panen, atau Manajemen Logistik/Rantai Pasok. Level Manager / Head: Minimal 5–8 tahun pengalaman di bidang operasional manufaktur pangan atau logistik skala industri, dengan minimal 3 tahun menjabat sebagai Factory Manager, Plant Manager, atau Operations Manager.\n\nKeahlian dan Sertifikasi:\n1. Keahlian Operasional & Pemrosesan Industri : Manajemen Operasional Pabrik (RMU/Dryer/Silo), Maintenance Management, dan Pengendalian Mutu;\n2. Keahlian Logistik & Manajemen Pergudangan (Logistics & Warehouse);\n3. Sertifikasi Ahli K3 Umum, Lead Auditor ISO 22000, Lean Green Belt, Manajer Logistik (BNSP).",
    "value_chain": "SOP Good Agricultural Practices (GAP) & Kalender Tanam per kawasan, Mekanisasi Pertanian",
    "method_cost": 150780000000.0
  },
  {
    "code": "1.B.2.1.3",
    "name": "KSPP Planning and Operation Control",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Mengendalikan perencanaan produksi dan memastikan kesesuaian antara target dan realisasi.\n\nTugas & Tanggung Jawab:\n1. Perencanaan Terintegrasi (Integrated Business Planning)\nMerumuskan perencanaan kapasitas produksi, kebutuhan input (benih, pupuk, alsintan), dan anggaran operasional (OpEx) tahunan dan per musim tanam untuk seluruh wilayah KSPP dan Menyusun jadwal induk operasional (master schedule) yang menyelaraskan antara prediksi panen di hulu, kapasitas tampung pabrik pengolahan di tengah, dan permintaan pasar di hilir.\n\n2. Pengendalian & Monitoring Operasional (Operation Control)\nMengembangkan dan mengelola sistem dasbor data operasional harian (misalnya berbasis ERP atau Agtech platform) untuk memantau progres tanam, perawatan, dan panen secara real-time dan Melakukan evaluasi berkala terhadap penyimpangan antara target perencanaan dan realisasi di lapangan (misalnya: keterlambatan jadwal tanam, pembengkakan biaya, atau penurunan yield), serta mengidentifikasi akar masalahnya (root cause analysis).\n\n3. Manajemen Risiko & Mitigasi Krisis Pangan Kawasan\nMembangun sistem peringatan dini terhadap risiko operasional seperti anomali cuaca, potensi serangan hama, atau kendala pasokan pupuk, lalu merumuskan rencana kontinjensi bersama tim operasi dan Merencanakan dan mengontrol tingkat persediaan aman (safety stock) untuk input pertanian dan hasil komoditas guna menghindari kelangkaan atau kelebihan pasokan di gudang kawasan.\n\n4. Evaluasi Efisiensi & Biaya (Cost & Productivity Control)\nMeninjau secara kritis Biaya Pokok Produksi (BPP) di setiap KSPP untuk memastikan penggunaan anggaran operasional efisien dan meminimalkan pemborosan (waste) dan Mengevaluasi tingkat utilitas aset (seperti kapasitas mesin RMU, drier, dan alsintan) untuk memastikan efektivitas penggunaan alat (Overall Equipment Effectiveness - OEE).\n\n5. Pelaporan Strategis (Reporting & Analytics)\nMenyusun laporan performa operasional berkala (mingguan/bulanan) yang komprehensif untuk diserahkan kepada Direktur Pangan dan jajaran direksi sebagai dasar pengambilan keputusan.",
    "qualification": "Kualifikasi :\nMinimal S1 (S2 diutamakan) di bidang Teknik Industri, Manajemen Operasi/Rantai Pasok, Agribisnis (fokus analitik/ekonomi), Statistika, atau Akuntansi/Finansial. Level Manager / Head: Minimal 5–8 tahun pengalaman di bidang Supply Chain Planning, Operational Excellence, atau PMO (Project Management Office) pada industri agribisnis, manufaktur, atau logistik skala besar, dengan minimal 3 tahun di posisi pimpinan tim.\n\nKeahlian dan Sertifikasi:\n1. Keahlian Analitik & Perencanaan (Planning & Analytics) : Perencanaan Kapasitas & Agregat (S&OP), Analisis Data Terstruktur, dan Kalkulasi Biaya Pokok Produksi (BPP);\n2. Pengendalian Operasional & Risiko (Operational Control) : Manajemen Persediaan (Inventory Control) dan Audit Kinerja & Lean Operations;\n3. CSCP (APICS), QRMP (Manajemen Risiko), Lean Black Belt, Certified Cost Analyst.",
    "value_chain": "Sistem Dashboard Operasional Terintegrasi (ERP/Agtech real-time), IoT Farm Monitoring",
    "method_cost": 15600000000.0
  },
  {
    "code": "1.B.2.2",
    "name": "Agro Production & Livestock Management",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Merencanakan, mengimplementasikan, dan mengawasi seluruh teknis budidaya pertanian serta pengelolaan peternakan di dalam KSPP. Posisi ini memastikan adopsi praktik agronomis terbaik (Good Agricultural Practices) dan standar peternakan yang higienis (Good Farming Practices) demi menghasilkan komoditas pangan nabati dan hewani yang berkualitas tinggi, aman konsumsi, serta berkelanjutan.\n\nTugas & Tanggung Jawab:\n1. Manajemen Budidaya Pertanian Modern (Agro Production)\nMenyusun dan mengawal implementasi Standard Operating Procedure (SOP) budidaya tanaman pangan (padi, jagung, kedelai, atau hortikultura), mulai dari olah tanah, pembibitan, pemeliharaan, hingga proteksi tanaman, Mengembangkan sistem Pengendalian Hama Terpadu (PHT) untuk memitigasi risiko gagal panen akibat serangan penyakit atau organisme pengganggu tanaman (OPT), dan Melakukan riset lapangan skala terbatas untuk menguji varietas benih baru yang lebih tahan iklim ekstrem dan memiliki potensi hasil (yield) lebih tinggi.\n\n2. Pengelolaan Peternakan Skala Industri (Livestock Management)\nMengawasi operasional harian peternakan (sapi, kambing/domba, atau unggas), meliputi aspek perkandangan, pembiakan (breeding), penggemukan (fattening), dan sanitasi lingkungan, Merformulasikan kebutuhan pakan berkualitas tinggi dan memastikan ketersediaan pasokan pakan secara konsisten untuk menunjang pertumbuhan ternak yang optimal, dan Menyusun program vaksinasi, pencegahan penyakit menular hewan, dan penanganan medis satwa bekerja sama dengan dokter hewan setempat.\n\n3. Integrasi Pertanian Terpadu (Integrated & Circular Farming)\nMengembangkan ekosistem sirkular di dalam KSPP, seperti mengolah limbah pertanian (sekam/jerami) menjadi pakan ternak berkualitas, serta mengolah kotoran ternak (manure) menjadi pupuk organik kompos untuk menyuburkan kembali lahan pertanian dan Merancang pemanfaatan lahan secara tumpang sari atau integrasi (misalnya sistem integrasi sapi-kelapa sawit/jagung) untuk meningkatkan produktivitas per satuan luas lahan.\n\n4. Pembinaan Teknis & Transfer Teknologi\nMenyelenggarakan pelatihan berkala dan penyuluhan teknik budidaya/peternakan modern kepada para petani lokal yang tergabung dalam kemitraan PT Agrinas dan Supervisi Tenaga Ahli Lapangan: Memimpin tim agronomis, dokter hewan, penyuluh, dan teknisi lapangan di seluruh site KSPP.",
    "qualification": "Kualifikasi :\nMinimal S1 (S2 sangat diutamakan) di bidang Pertanian (Agronomi/Budidaya/Ilmu Tanah) ATAU Peternakan (Ilmu Peternakan/Nutrisi Pakan/Kedokteran Hewan) yang memiliki portofolio atau pengalaman kerja di kedua bidang tersebut. Level Manager / Head: Minimal 6–10 tahun pengalaman profesional, dengan minimal 3–4 tahun memimpin proyek integrated farming system skala besar, estate terintegrasi (misal: integrasi sawit-sapi, jagung-ternak), atau kawasan food estate.\n\nKeahlian dan Sertifikasi:\n1. Keahlian Teknis Integrasi (Integrated Farming Mastery) : Manajemen Sirkularitas & Zero Waste, Agronomi & Kesehatan Tanaman, dan Zooteknik & Biosekuriti Peternakan;\n2. Keahlian Manajerial & Bisnis;\n3. Sertifikasi Kompetensi Hulu (BNSP); \n4. Sertifikasi Keamanan Pangan & Sistem Manajemen : Sertifikasi ISO 14001 (Sistem Manajemen Lingkungan);\n5. Sertifikasi Penunjang & K3",
    "value_chain": "Metodologi Integrated & Circular Farming",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.2.2.1",
    "name": "Crop Production",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Bertanggung jawab atas perencanaan teknis, eksekusi budidaya, proteksi tanaman, hingga penentuan metode pemanenan komoditas tanaman pangan (seperti padi, jagung, singkong atau hortikultura). Posisi ini memastikan seluruh aktivitas di ladang/sawah menerapkan Good Agricultural Practices (GAP) dan teknologi smart farming demi mengamankan pasokan pangan nasional yang berkualitas dan bernilai ekonomis tinggi.\n\nTugas & Tanggung Jawab:\n1. Perencanaan Budidaya & Kalender Tanam (Agronomy Planning)\nMerancang kalender tanam yang presisi berdasarkan analisis data cuaca, ketersediaan air, dan target serapan pasar guna menghindari risiko gagal panen akibat faktor alam atau oversupply dan Merencanakan dan memastikan kebutuhan benih unggul, pupuk (organik/anorganik), dan pembenah tanah tersedia tepat waktu sebelum musim tanam dimulai.\n\n2. Supervisi Operasional Lapangan & Mekanisasi (Hulu)\nMenyusun dan mengawal implementasi SOP teknis mulai dari pengolahan lahan (pembajakan), penanaman, penyiraman/irigasi, hingga pemupukan berimbang dan Mengarahkan penggunaan teknologi mekanisasi skala industri, seperti penggunaan traktor otonom, drone untuk pemupukan cair, serta otomatisasi sistem irigasi tetes atau sprinkler.\n\n3. Manajemen Kesehatan Tanaman & Proteksi (Crop Protection)\nMemantau kondisi lapangan secara rutin (scouting) untuk mendeteksi dini gejala serangan organisme pengganggu tanaman (OPT) seperti ulat, jamur, atau virus, serta menentukan tindakan kuratif yang ramah lingkungan dan Melakukan pengujian berkala terhadap kondisi hara tanah dan tingkat keasaman (pH) tanah untuk merumuskan dosis pemupukan yang paling efisien namun berdampak maksimal.\n\n4. Manajemen Pemanenan & Penekanan Food Loss\nMenentukan waktu panen yang tepat berdasarkan tingkat kematangan fisiologis tanaman agar menghasilkan kualitas gabah/komoditas dengan rendemen tertinggi dan Mengawasi jalannya pemanenan menggunakan combine harvester untuk mempercepat proses sekaligus menekan angka kehilangan hasil (harvest loss) di sawah/ladang.\n\n5. Pembinaan Kemitraan Petani Swadaya\nMemberikan asistensi teknis dan pelatihan mengenai metode pertanian modern kepada kelompok tani lokal yang menjadi mitra pasok PT APN dalam ekosistem KSPP.",
    "qualification": "Kualifikasi:\nMinimal S1 (S2 diutamakan) di bidang Agronomi, Budidaya Pertanian, Ilmu Tanah, Proteksi Tanaman, atau Teknik Pertanian. Level Manager / Head: Minimal 5–8 tahun pengalaman di perkebunan komersial, perusahaan benih, atau proyek food estate, dengan minimal 3 tahun di posisi supervisi/manajerial lapangan.\n\nKeahlian dan Sertifikasi:\n1. Keahlian Teknis Agronomi : Manajemen Nutrisi Tanaman & Tanah, Fitopatologi & Proteksi Tanaman, dan Teknologi Smart Farming & Alsintan;\n2. Keahlian Operasional & Manajerial : Analisis Data Produktivitas dan Manajemen Logistik Hulu;\n3. Sertifikasi Kompetensi Teknis (BNSP);\n4. Sertifikasi Standar Mutu & Keamanan Pangan;\n5. Sertifikasi Ahli K3 Umum / K3 Sektor Pertanian.",
    "value_chain": "SOP GAP & Pengendalian Hama Terpadu (PHT) per kawasan",
    "method_cost": 130000000.0
  },
  {
    "code": "1.B.2.2.2",
    "name": "Livestock Management",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Bertanggung jawab atas perencanaan teknis, pemeliharaan, kesehatan hewan, formulasi pakan, hingga proses pemanenan/pascapanen produk peternakan. Posisi ini memastikan seluruh operasional kandang menerapkan Good Farming Practices (GFP) dan standar biosekuriti yang ketat demi menghasilkan daging, susu, atau telur berkualitas tinggi secara efisien dan berkelanjutan.\n\nTugas & Tanggung Jawab:\n1. Perencanaan Populasi & Pembiakan (Livestock Planning & Breeding)\nMenyusun rencana kapasitas kandang, jadwal pengadaan bakalan (bibit ternak), serta target waktu penggemukan atau masa produktif ternak dan Mengembangkan program pembiakan (breeding) yang efektif, termasuk penerapan teknologi Inseminasi Buatan (IB) atau transfer embrio untuk menghasilkan keturunan ternak dengan genetika unggul.\n\n2. Manajemen Nutrisi & Formulasi Pakan (Feeding & Nutrition)\nMerancang dan menghitung formulasi pakan harian yang kaya nutrisi namun efisien secara biaya, guna mencapai target bobot ternak yang optimal dan Memastikan ketersediaan bahan baku pakan secara kontinu, termasuk mengelola pengolahan hijauan (silase/amoniase) memanfaatkan limbah pertanian dari area Crop Production (sirkular).\n\n3. Biosekuriti & Kesehatan Hewan\nMenyusun dan mengawal jadwal vaksinasi, pemberian vitamin, dan penataan sanitasi kandang guna mencegah masuknya wabah penyakit menular (seperti PMK, Flu Burung, dll) dan Mengidentifikasi ternak yang sakit, melakukan tindakan karantina mandiri, dan berkoordinasi dengan dokter hewan untuk pengobatan yang cepat agar tidak menular ke populasi lain.\n\n4. Operasional Kandang Modern & Pascapanen (Tengah)\nMengawasi penggunaan teknologi kandang modern, seperti pengatur suhu otomatis (closed house system pada unggas), mesin pemerah susu otomatis, atau sistem pengolahan kotoran mekanis dan Memastikan proses pemanenan (baik ternak siap potong, telur, atau susu) dilakukan dengan higienis dan langsung disimpan di lemari pendingin untuk menjaga kesegaran.\n\n5. Pengelolaan Limbah \nMengolah limbah kotoran ternak menjadi pupuk organik siap pakai untuk disuplai kembali ke lahan pertanian KSPP, meminimalkan dampak lingkungan dan bau di sekitar kawasan.",
    "qualification": "Kualifikasi:\nS1/S2 Agronomi, Agribisnis, Ilmu Peternakan, Kedokteran Hewan, atau bidang terkait.\n\nKeahlian dan Sertifikasi:\n1. Paham implementasi Good Agricultural Practices (GAP) & Good Animal Husbandry Practices (GAHP);\n2. Mampu menganalisis data cuaca, tren pasar pangan, dan estimasi hasil produksi (yield forecasting);\n3. Memiliki kemampuan memimpin tim yang besar di lapangan dan siap bekerja dengan mobilitas tinggi;",
    "value_chain": "SOP Good Farming Practices (GFP) & Program Biosekuriti per kawasan",
    "method_cost": 130000000.0
  },
  {
    "code": "1.B.2.2.3",
    "name": "Farmer and Breeder Engagement",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Bertanggung jawab untuk merancang, mengeksekusi, dan mengelola program kemitraan inklusif terintegrasi antara PT Agrinas Pangan Nusantara (Persero) dengan komunitas petani dan peternak lokal. Peran utama posisi ini adalah melakukan rekrutmen mitra, mengamankan kontrak pasokan (off-take agreements), mengelola kelembagaan petani (koperasi/kelompok tani), serta memitigasi konflik sosial demi terciptanya rantai pasok hulu yang stabil bagi perusahaan.\n\nTugas & Tanggung Jawab:\n1. Rekrutmen & Akuisisi Mitra\nMelakukan pemetaan sosial (social mapping) untuk mengidentifikasi kelompok tani (Poktan), gabungan kelompok tani (Gapoktan), atau koperasi potensial di sekitar wilayah KSPP, Mengedukasi masyarakat lokal mengenai keuntungan bergabung dengan ekosistem PT APN (seperti kepastian serapan hasil panen, akses modal, dan bantuan teknologi), dan Menyusun, menegosiasikan, dan mengawal penandatanganan Perjanjian Kerja Sama (PKS) kemitraan yang adil dan menguntungkan kedua belah pihak.\n\n2. Pendampingan & Penguatan Kelembagaan \nMengkonsolidasikan para petani individual ke dalam bentuk kelembagaan yang lebih profesional (seperti Koperasi) agar mudah berkoordinasi dalam skala industri, Menghubungkan para mitra dengan lembaga keuangan (perbankan/KUR) dan memastikan mereka mendapatkan akses input pertanian/peternakan (benih, pupuk, pakan) berkualitas dari perusahaan, dan Menyelenggarakan pelatihan terkait literasi keuangan, manajemen kelompok, dan kewirausahaan agribisnis bagi pengurus kelompok tani/ternak.\n\n3. Komunikasi & Manajemen Konflik\nMenjadi mediator utama jika terjadi perselisihan antara perusahaan dengan mitra (misalnya terkait ketidaksesuaian harga beli, standar sortir mutu, atau keterlambatan pembayaran) dan Menyediakan wadah komunikasi yang aktif bagi para mitra untuk menyampaikan keluhan atau masukan guna perbaikan sistem kemitraan perusahaan.\n\n4. Pengawasan Kepatuhan Kontrak\nMemantau agar para mitra tetap menjual hasil panen/ternaknya ke PT APN sesuai kontrak dan mencegah terjadinya side-selling (petani menjual ke tengkulak lain saat harga pasar melonjak) dan Berkoordinasi dengan tim Crop dan Livestock Management terkait perkiraan volume panen para mitra demi ketepatan jadwal serapan oleh logistik perusahaan.",
    "qualification": "Kualifikasi:\nS1 Penyuluhan Pertanian, Sosiologi, Agribisnis, Komunikasi, atau Pengembangan Masyarakat dan Bidang terkait (Bidang Pertanian/Sosial).\n\nKeahlian dan Sertifikasi:\n1. Memiliki kemampuan komunikasi persuasif dan negosiasi yang sangat kuat;\n2. Memahami hukum kontrak kemitraan agribisnis di Indonesia\n3. Menguasai metode pendekatan sosial masyarakat pedesaan\n4. Memiliki kemampuan problem-solving yang tinggi di lapangan;\n5. Memiliki kemampuan beradaptasi;\n6. Sertifikasi Bidang Penyuluhan, Sertifikasi Manajemen Proyek & Keberlanjutan, dan Sertifikasi Manajemen Konflik & Negosiasi",
    "value_chain": "Metodologi Kemitraan Petani/Peternak (off-taker agreement & PKS), Contract Farming Development (unit cost dikoreksi)",
    "method_cost": 100250000000.0
  },
  {
    "code": "1.B.2.2.4",
    "name": "Crop and Food Production",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengintegrasikan produksi bahan baku pangan dengan kebutuhan industri pangan.\n\nUraian Tugas dan Tanggungjawab: \n1. Mengelola keseluruhan proses produksi pangan berbasis tanaman, mulai dari hasil panen hingga siap masuk tahap pengolahan.\n\n2. Menetapkan standar mutu bahan baku hasil pertanian yang akan diproses menjadi produk pangan bernilai tambah.\n\n3. Mengoordinasikan aliran pasokan hasil panen dari kawasan produksi ke fasilitas pascapanen dan pengolahan (RMU/FMU/gudang/silo).\n\n4. Bekerja sama dengan tim Processing and Food Production untuk memastikan efisiensi rantai pasok dari lahan ke fasilitas pengolahan.\n\n5. Memantau tingkat susut hasil (losses), kualitas penyimpanan, dan efisiensi logistik hasil panen.",
    "qualification": "Kualifikasi:\n1. Pendidikan minimal S1 Teknologi Pangan, Agribisnis, Agroteknologi, Agronomi, Teknik Pertanian, Teknik Industri. \n\n2. Pengalaman minimal 5 tahun dalam pengelolaan pascapanen dan rantai pasok hasil pertanian. \n\n3. Memahami proses pascapanen (pengeringan, penyimpanan, penggilingan) dan standar mutu bahan baku pangan.\n\n\nKeahlian dan Sertifikasi:\n1. Kemampuan manajemen rantai pasok hasil pertanian dari kawasan ke fasilitas pengolahan.\n\n2. Pemahaman teknis pascapanen dan pengendalian mutu bahan baku.\n\n3. Kemampuan analisis efisiensi logistik dan pengurangan susut hasil panen.\n\n4. Sertifikasi HACCP/manajemen mutu pangan menjadi nilai tambah.",
    "value_chain": "Standar Mutu Bahan Baku & Koordinasi Rantai Pasok Hasil Panen",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.2.3",
    "name": "Processing and Food Production",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengelola proses pengolahan pangan untuk menghasilkan produk yang aman, berkualitas, dan bernilai tambah.\n\nUraian Tugas dan Tanggungjawab:\n1. Memimpin fungsi pengolahan hasil pertanian dan peternakan menjadi produk pangan siap distribusi, mencakup pengoperasian fasilitas RMU (Rice Milling Unit), FMU (Factory Milling Unit), dan unit pengolahan lainnya.\n\n2. Menyusun rencana produksi pengolahan sesuai kapasitas fasilitas dan permintaan pasar/distribusi.\n\n3. Mengoordinasikan tim Food Processing (Crop Based) dan Dairy and Meat Processing agar proses pengolahan berjalan efisien dan sesuai standar mutu serta keamanan pangan.\n\n4. Memastikan seluruh proses produksi memenuhi standar keamanan pangan (food safety), higienitas, dan regulasi yang berlaku (BPOM, SNI, Halal, dsb.).\n\n5. Melaporkan volume produksi, tingkat efisiensi (yield), dan kualitas produk olahan secara berkala kepada manajemen.",
    "qualification": "Kualifikasi: \n1. Pendidikan minimal S1 di bidang Teknologi Pangan, Teknik Industri Pangan, atau bidang terkait; S2 menjadi nilai tambah. \n\n2. Pengalaman minimal 7 tahun dalam industri pengolahan pangan, dengan minimal 3 tahun pada posisi manajerial. \n\n3. Memahami sistem manajemen mutu dan keamanan pangan (HACCP, ISO 22000) serta regulasi pangan nasional.\n\n\nKeahlian dan Sertifikasi:\n1. Kepemimpinan operasional pabrik/fasilitas pengolahan pangan.\n\n2. Pemahaman mendalam mengenai proses pengolahan pangan berbasis tanaman maupun hewani.\n\n3. Kemampuan manajemen mutu, keamanan pangan, dan efisiensi produksi (yield optimization).\n\n4. Sertifikasi HACCP, ISO 22000, dan/atau auditor Halal menjadi nilai tambah kuat.",
    "value_chain": "Sertifikasi ISO 22000/HACCP & Halal per lini pengolahan, Quality Assurance Center, Food Safety Laboratory",
    "method_cost": 48660000000.0
  },
  {
    "code": "1.B.2.3.1",
    "name": "Food Processing (Crop Based)",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengelola pengolahan hasil tanaman menjadi produk bernilai tambah.\n\nUraian Tugas dan Tanggungjawab:\n1. Mengelola operasional pengolahan hasil tanaman pangan (beras, jagung, umbi-umbian, dll.) menjadi produk siap konsumsi/distribusi melalui fasilitas seperti RMU dan FMU.\n\n2. Mengawasi proses pengeringan, penggilingan, sortasi, dan pengemasan hasil olahan tanaman sesuai standar mutu.\n\n3. Melakukan pengendalian mutu bahan baku dan produk jadi melalui sampling dan pengujian sesuai prosedur.\n\n4. Mengoptimalkan penggunaan mesin dan peralatan pengolahan untuk mencapai efisiensi produksi (rendemen) yang optimal.\n\n5. Berkoordinasi dengan tim Facility and Maintenance untuk memastikan peralatan produksi dalam kondisi optimal.",
    "qualification": "Kualifikasi:\n1. Pendidikan minimal S1 di bidang Teknologi Pangan, Teknik Industri, atau Teknik Mesin (dengan pengalaman di industri pangan).\n\n2. Pengalaman minimal 4 tahun dalam operasional pengolahan hasil pertanian berbasis tanaman (rice milling, grain processing).\n\n3. Memahami prinsip dasar pengendalian mutu dan keamanan pangan.\n\n\nKeahlian dan Sertifikasi:\n1. Penguasaan teknis operasional mesin penggilingan dan pengeringan (RMU/FMU).\n\n2. Kemampuan pengendalian mutu produk olahan berbasis tanaman.\n\n3. Pemahaman prinsip keamanan pangan dan higienitas pengolahan.\n\n4. Sertifikasi HACCP atau pelatihan teknis food processing menjadi nilai tambah.",
    "value_chain": "SOP Pengolahan RMU/FMU (pengeringan, penggilingan, sortasi)",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.2.3.2",
    "name": "Dairy and Meat Processing",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengelola pengolahan susu dan daging secara modern dan higienis.\n\nUraian Tugas dan Tanggungjawab:\n1. Mengelola operasional pengolahan hasil ternak (susu dan daging) menjadi produk pangan olahan yang siap distribusi.\n\n2. Mengawasi proses penerimaan bahan baku, pengolahan, pengemasan, dan penyimpanan produk susu dan daging sesuai standar rantai dingin (cold chain).\n\n3. Memastikan penerapan standar keamanan pangan dan higienitas yang ketat mengingat sifat produk yang mudah rusak (perishable).\n\n4. Melakukan pengendalian mutu produk olahan susu dan daging melalui pengujian laboratorium dan inspeksi rutin.\n\n5. Berkoordinasi dengan tim Livestock Management dan Livestock System and Nutrition terkait kualitas bahan baku dari peternakan.",
    "qualification": "Kualifikasi: \n1. Pendidikan minimal S1 di bidang Teknologi Pangan, Peternakan (dengan konsentrasi pengolahan hasil ternak), atau bidang terkait.\n\n2. Pengalaman minimal 4 tahun dalam industri pengolahan produk susu dan/atau daging.\n\n3. Memahami prinsip rantai dingin (cold chain) dan sistem keamanan pangan untuk produk hewani.\n\n\nKeahlian dan Sertifikasi:\n1. Penguasaan teknis pengolahan produk susu dan daging (pasteurisasi, pemotongan, pengemasan, dsb.).\n\n2. Pemahaman sistem manajemen rantai dingin dan penyimpanan produk perishable.\n\n3. Kemampuan pengendalian mutu dan keamanan pangan produk hewani.\n\n4. Sertifikasi HACCP, penanganan daging (RPH bersertifikat/Juru Sembelih Halal), atau sertifikasi Halal menjadi nilai tambah.",
    "value_chain": "SOP Cold Chain Management & Higienitas Produk Perishable",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.2.3.3",
    "name": "Facility and Maintenance",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Menjamin keandalan seluruh fasilitas dan peralatan produksi.\n\nUraian Tugas dan Tanggungjawab: \n1. Mengelola pemeliharaan seluruh fasilitas dan infrastruktur kawasan, termasuk bangunan, gudang, silo, RMU/FMU, kandang, jaringan irigasi, dan alat mesin pertanian (alsintan).\n\n2. Menyusun dan melaksanakan program pemeliharaan preventif dan perbaikan korektif (preventive & corrective maintenance) untuk seluruh aset fasilitas.\n\n3. Mengelola persediaan suku cadang dan mengoordinasikan perbaikan dengan pihak internal maupun vendor eksternal.\n\n4. Memastikan seluruh fasilitas dan peralatan beroperasi sesuai standar keselamatan kerja (K3) dan siap mendukung kegiatan produksi tanpa gangguan.\n\n5. Menyusun anggaran pemeliharaan fasilitas dan melaporkan kondisi aset serta kebutuhan investasi perbaikan/penggantian kepada Manager KSPP.",
    "qualification": "Kualifikasi:\n1. Pendidikan minimal S1 di bidang Teknik Mesin, Teknik Elektro, Teknik Industri, atau bidang terkait.\n\n2. Pengalaman minimal 5 tahun dalam manajemen fasilitas, pemeliharaan mesin/peralatan industri, atau pemeliharaan infrastruktur pertanian.\n\n3. Memahami prinsip dasar preventive maintenance, manajemen aset, dan keselamatan kerja (K3).\n\n\nKeahlian dan Sertifikasi:\n1. Kemampuan manajemen pemeliharaan fasilitas dan peralatan berskala besar.\n\n2. Pemahaman teknis kelistrikan, permesinan, dan sistem irigasi/utilitas kawasan.\n\n3. Kemampuan penyusunan jadwal pemeliharaan dan manajemen anggaran perawatan aset.\n\n4. Sertifikasi K3 Umum atau sertifikasi teknis kompetensi pemeliharaan mesin/listrik menjadi nilai tambah.",
    "value_chain": "Sistem Preventive & Corrective Maintenance Fasilitas",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.2.4",
    "name": "Technical Agribusiness & Land Development",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengembangkan infrastruktur teknis agribisnis dan lahan produksi.\n\nUraian Tugas dan Tanggungjawab: \n1. Memimpin fungsi teknis pengembangan lahan dan keahlian agribisnis untuk mendukung pengembangan kawasan produksi pangan secara berkelanjutan.\n\n2. Mengoordinasikan tim Agronomy and Crop System, Livestock System and Nutrition, serta Land and Topography Development dalam menyediakan dukungan teknis kepada operasional kawasan.\n\n3. Menyusun standar teknis dan rekomendasi ilmiah terkait pemilihan komoditas, sistem budi daya, dan pengembangan lahan yang sesuai dengan karakteristik masing-masing kawasan.\n\n4. Mengevaluasi dan mengadopsi teknologi/inovasi pertanian-peternakan terbaru untuk meningkatkan produktivitas dan efisiensi kawasan.\n\n5. Memberikan dukungan teknis kepada tim KSPP Development dan Agro Production and Livestock Management dalam perencanaan dan pelaksanaan proyek.",
    "qualification": "Kualifikasi:\n1. Pendidikan minimal S1 di bidang Pertanian, Peternakan, Teknik Sipil/Geodesi, atau bidang terkait; S2 menjadi nilai tambah.\n\n2. Pengalaman minimal 7 tahun di bidang teknis agribisnis, pengembangan lahan, atau riset dan pengembangan pertanian/peternakan.\n\n3. Memiliki wawasan luas mengenai agronomi, sistem peternakan, dan pengembangan lahan/topografi secara terintegrasi.\n\n\nKeahlian dan Sertifikasi:\n1. Kepemimpinan tim teknis multidisiplin (agronomi, peternakan, dan teknik lahan).\n\n2. Kemampuan riset terapan dan penyusunan rekomendasi teknis berbasis data.\n\n3. Pemahaman mendalam mengenai teknologi pertanian-peternakan terkini (precision farming, dsb.).\n\n4. Sertifikasi keahlian teknis di bidang pertanian/peternakan/geodesi atau keanggotaan asosiasi profesi terkait menjadi nilai tambah.",
    "value_chain": "Metodologi Riset Terapan Agronomi-Peternakan-Topografi",
    "method_cost": 300000000.0
  },
  {
    "code": "1.B.2.4.1",
    "name": "Agronomy and Crop System",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengembangkan sistem budidaya tanaman berbasis pertanian presisi.\n\nUraian Tugas dan Tanggungjawab: \n1. Merancang sistem budi daya tanaman (cropping system) yang sesuai dengan agroklimat, jenis tanah, dan komoditas unggulan di setiap kawasan.\n\n2. Melakukan kajian dan uji coba varietas unggul, pola tanam, serta teknik budi daya untuk meningkatkan produktivitas dan ketahanan tanaman.\n\n3. Menyusun rekomendasi teknis pemupukan, irigasi, dan pengendalian hama-penyakit berbasis hasil analisis tanah dan kondisi lapangan.\n\n4. Memberikan pendampingan teknis kepada tim Crop Production dalam penerapan praktik agronomi terbaik.\n\n5. Memantau perkembangan riset dan inovasi agronomi terkini untuk diterapkan pada operasional kawasan.",
    "qualification": "Kualifikasi:\n1. Pendidikan minimal S1 di bidang Agronomi atau Ilmu Tanah; S2 menjadi nilai tambah, khususnya bagi kandidat dengan fokus riset.\n\n2. Pengalaman minimal 5 tahun dalam riset atau penerapan teknis agronomi pada skala produksi komersial.\n\n3. Memahami metodologi uji coba lapangan (field trial) dan analisis data agronomi.\n\nKeahlian dan Sertifikasi:\n1. Penguasaan ilmu agronomi, fisiologi tanaman, dan kesuburan tanah.\n\n2. Kemampuan merancang dan menganalisis uji coba lapangan (field trial).\n\n3. Kemampuan menyusun rekomendasi teknis berbasis data ilmiah untuk tim operasional.\n\n4. Sertifikasi profesi agronomis atau pelatihan teknis budi daya lanjutan menjadi nilai tambah.",
    "value_chain": "Metodologi Field Trial & Rekomendasi Pemupukan/Irigasi, Precision Farming (unit cost dikoreksi)",
    "method_cost": 50200000000.0
  },
  {
    "code": "1.B.2.4.2",
    "name": "Livestock system and nutrition",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengembangkan sistem peternakan dan nutrisi yang optimal.\n\nUraian Tugas dan Tanggungjawab: \n1. Merancang sistem pemeliharaan ternak dan formulasi pakan yang optimal sesuai jenis ternak, tujuan produksi, dan ketersediaan bahan baku lokal.\n\n2. Melakukan kajian kebutuhan nutrisi ternak pada berbagai fase pertumbuhan/produksi dan menyusun standar formulasi pakan.\n\n3. Mengevaluasi performa sistem pemeliharaan ternak yang diterapkan dan memberikan rekomendasi perbaikan.\n\n4. Memberikan pendampingan teknis kepada tim Livestock Management terkait penerapan sistem pemeliharaan dan nutrisi yang direkomendasikan.\n\n5. Memantau perkembangan riset dan teknologi nutrisi/peternakan terkini untuk diterapkan pada operasional kawasan.",
    "qualification": "Kualifikasi:\n1. Pendidikan minimal S1 di bidang Peternakan (dengan fokus Nutrisi dan Makanan Ternak) atau Kedokteran Hewan; S2 menjadi nilai tambah.\n\n2. Pengalaman minimal 5 tahun dalam bidang nutrisi ternak, formulasi pakan, atau sistem produksi peternakan komersial.\n\n3. Memahami metodologi penyusunan ransum dan evaluasi performa ternak berbasis data.\n\n\nKeahlian dan Sertifikasi:\n1. Penguasaan ilmu nutrisi ternak dan teknik formulasi pakan (ransum).\n\n2. Kemampuan analisis data performa ternak (feed conversion ratio, tingkat pertumbuhan, dsb.).\n\n3. Pemahaman sistem pemeliharaan ternak modern dan prinsip kesejahteraan hewan (animal welfare).\n\n4. Sertifikasi profesi nutrisionis ternak atau pelatihan teknis peternakan lanjutan menjadi nilai tambah.",
    "value_chain": "Metodologi Formulasi Pakan & Evaluasi Performa Ternak (FCR)",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.2.4.3",
    "name": "Land and Topography Development",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengelola pengembangan lahan, topografi, dan infrastruktur pendukung produksi.\n\nUraian Tugas dan Tanggungjawab: \n1. Melakukan survei, pemetaan, dan analisis topografi lahan untuk mendukung perencanaan pengembangan Kawasan Sentra Produksi Pangan.\n\n2. Menyusun desain teknis pengembangan lahan, termasuk tata letak petak lahan, sistem drainase, dan jaringan irigasi berbasis kondisi topografi.\n\n3. Melakukan kajian kesesuaian lahan (land suitability) untuk menentukan komoditas dan sistem produksi yang optimal pada setiap kawasan.\n\n4. Berkoordinasi dengan tim KSPP Development terkait perencanaan teknis pencetakan dan pematangan lahan.\n\n5. Mengawasi pelaksanaan pekerjaan pematangan lahan di lapangan agar sesuai dengan desain dan spesifikasi teknis.",
    "qualification": "Kualifikasi:\n1. Pendidikan minimal S1 di bidang Teknik Geodesi, Teknik Sipil, Ilmu Tanah, atau Perencanaan Wilayah.\n\n2. Pengalaman minimal 4-5 tahun dalam survei topografi, pengembangan lahan, atau pekerjaan sipil terkait infrastruktur pertanian.\n\n3. Memahami prinsip dasar hidrologi lahan, drainase, dan tata guna lahan pertanian.\n\n\nKeahlian dan Sertifikasi:\n1. Penguasaan survei dan pemetaan topografi (total station, GPS geodetik, drone survey/fotogrametri).\n\n2. Penguasaan perangkat lunak GIS dan CAD (ArcGIS/QGIS, AutoCAD Civil 3D atau setara).\n\n3. Kemampuan analisis kesesuaian lahan dan perencanaan tata letak kawasan produksi.\n\n4. Sertifikasi keahlian Geodesi/Surveyor bersertifikat (misalnya sertifikasi dari asosiasi profesi geodesi) menjadi nilai tambah.",
    "value_chain": "Sistem Survei & Pemetaan Topografi (GIS/CAD)",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.3",
    "name": "Direktur Retail dan Distribusi",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengelola strategi \ndan operasional retail serta distribusi secara end-to-end\nMenjamin ketersediaan produk di seluruh channel retail\nMengoptimalkan kinerja penjualan dan supply chain\nMenjaga efisiensi distribusi dan tingkat service level ke pelanggan\n\nTugas dan Tanggung Jawab\n\nMenyusun strategi retail, demand, dan distribusi nasional/regional\nMengendalikan supply chain dari demand forecasting hingga distribusi akhir\nMenetapkan KPI retail performance dan distribusi\nMengoptimalkan inventory dan availability produk\nMengkoordinasikan seluruh divisi di bawahnya (planning, forecasting, distribution)\nMengelola risiko supply chain (stockout, overstock, lead time)",
    "qualification": "Kualifikasi:\nPendidikan minimal S1/S2 Manajemen, Ekonomi, Logistik, Supply Chain, atau bidang terkait\nPengalaman 10–15 tahun di retail, distribusi, atau supply chain management\nMemiliki pengalaman leadership level senior (GM/Director)\nMenguasai end-to-end retail operation, demand-supply planning, dan distribution network\nKemampuan strategic planning, data-driven decision making, dan financial acumen tinggi\nMemahami sistem ERP, supply chain analytics, dan retail performance system",
    "value_chain": "Framework End-to-End Retail & Distribution Governance",
    "method_cost": 300000000.0
  },
  {
    "code": "1.B.3.1",
    "name": "Retail Performnace and Demand Management",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengelola perencanaan permintaan dan kinerja retail berbasis data\nMenyelaraskan demand, supply, dan performance retail\n\n\n\nTugas dan Tanggung Jawab\n\nMenyusun demand planning dan forecasting penjualan\nMengukur dan menganalisis performa retail\nMenyediakan insight untuk replenishment dan distribusi\nMelakukan evaluasi tren pasar dan pola permintaan",
    "qualification": "Kualifikasi:\nPengalaman 5–10 tahun di demand planning / retail analytics\nMenguasai forecasting model, data analytics tools (Excel advanced, BI tools, ERP)\nStrong analytical & problem solving\nStrong analytical & problem solving",
    "value_chain": "Sistem Demand Planning & Retail Performance Dashboard",
    "method_cost": 350000000.0
  },
  {
    "code": "1.B.3.1.1",
    "name": "Demand Planning and Forecast",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Menyusun proyeksi permintaan produk secara akurat\n\n\n\n\nTugas dan Tanggung Jawab\n\nMembuat forecast permintaan berdasarkan historical data\nAnalisis tren pasar, seasonality, dan promo impact\nKoordinasi dengan sales & marketing untuk input demand\nUpdate forecast secara berkala (rolling forecast)",
    "qualification": "Kualifikasi:\nS1 Statistik, Matematika, Ekonomi, Supply Chain\n3–7 tahun pengalaman demand planning\nMenguasai forecasting model (time series, regression)\nFamiliar dengan tools ERP/SAP/BI",
    "value_chain": "Metodologi Forecasting (time series/regression) & rolling forecast, AI Demand Forecasting",
    "method_cost": 12200000000.0
  },
  {
    "code": "1.B.3.1.2",
    "name": "Replenishment Planning",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Menjamin ketersediaan stok sesuai demand forecast\n\n\n\n\nTugas dan Tanggung Jawab\n\nMenyusun rencana replenishment stock\nMengatur reorder point & safety stock\nMonitoring inventory level di seluruh channel\nKoordinasi dengan procurement dan warehouse",
    "qualification": "Kualifikasi:\nS1 Logistik, Manajemen, Supply Chain\nPengalaman 3–7 tahun inventory planning\nMenguasai inventory control & ERP system",
    "value_chain": "Sistem Reorder Point & Safety Stock Planning",
    "method_cost": 180000000.0
  },
  {
    "code": "1.B.3.1.3",
    "name": "Retail Performance Analyst",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Menganalisis kinerja retail berbasis data\n\nTugas dan Tanggung Jawab\n\nMembuat dashboard retail performance\nAnalisis KPI (sales, margin, conversion rate)\nIdentifikasi masalah performa outlet/channel\nMenyediakan insight untuk decision making",
    "qualification": "Kualifikasi:\nS1 Statistik, Data Science, Ekonomi, IT\n2–5 tahun pengalaman data analyst retail\nMenguasai BI tools (Power BI/Tableau), SQL, Excel advanced",
    "value_chain": "Dashboard KPI Retail (sales, margin, conversion rate), Consumer Insight Platform",
    "method_cost": 6150000000.0
  },
  {
    "code": "1.B.3.2",
    "name": "Distribution and Availability Management",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengelola distribusi barang dan memastikan ketersediaan produk di seluruh channel\n\nTugas dan Tanggung Jawab\n\nMengatur jaringan distribusi nasional/regional\nMemastikan SLA pengiriman terpenuhi\nMengoptimalkan flow barang dari gudang ke outlet\nMonitoring availability produk di seluruh channel",
    "qualification": "Kualifikasi:\nS1 Logistik, Supply Chain, Teknik Industri, Manajemen\n5–10 tahun pengalaman distribusi/logistik\nMenguasai network distribution & warehouse management\nStrong coordination & operational control",
    "value_chain": "Sistem Distribution Network & SLA Management",
    "method_cost": 350000000.0
  },
  {
    "code": "1.B.3.2.1",
    "name": "Distribution Coordination",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengkoordinasikan aktivitas distribusi antar unit\n\nTugas dan Tanggung Jawab\n\nKoordinasi pengiriman dengan warehouse & transporter\nMonitoring lead time distribusi\nPenanganan issue delivery (delay, shortage)\nSinkronisasi kebutuhan outlet dengan supply chain",
    "qualification": "Kualifikasi:\nS1 Logistik, Manajemen, Teknik Industri\n2–5 tahun pengalaman koordinasi distribusi\nKomunikasi dan koordinasi tinggi",
    "value_chain": "SOP Koordinasi Pengiriman & Monitoring Lead Time",
    "method_cost": 150000000.0
  },
  {
    "code": "1.B.3.2.2",
    "name": "Availability and Replenishment Execution",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Menjalankan eksekusi replenishment untuk menjaga ketersediaan produk di semua channel\n\nTugas dan Tanggung Jawab\n\nMengeksekusi replenishment berdasarkan forecast & stock policy\nMonitoring stock availability di DC dan outlet\nMenangani out-of-stock dan overstock secara operasional\nKoordinasi dengan warehouse, procurement, dan transport\nMenjaga service level availability produk",
    "qualification": "Kualifikasi:\nS1 Logistik, Supply Chain, Teknik Industri, Manajemen\nPengalaman 3–7 tahun di supply chain execution / replenishment\nMenguasai ERP (SAP/Oracle), inventory system, dan order management\nMemahami end-to-end supply chain flow",
    "value_chain": "Sistem Eksekusi Replenishment & Stock Availability Monitoring",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.3.2.3",
    "name": "Inventory Control",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengendalikan akurasi dan efisiensi persediaan barang\n\nTugas dan Tanggung Jawab\n\nMonitoring akurasi stok di seluruh gudang dan outlet\nStock opname dan rekonsiliasi inventory\nAnalisis aging stock, dead stock, dan slow moving item\nMenetapkan standar inventory control\nMencegah selisih stok (shrinkage/losses)",
    "qualification": "Kualifikasi:\nS1 Akuntansi, Logistik, Supply Chain, Teknik Industri\n3–8 tahun pengalaman inventory control/audit stock\nMenguasai inventory system, audit stock, dan reconciliation",
    "value_chain": "Metodologi Stock Opname & Aging/Dead Stock Analysis",
    "method_cost": 180000000.0
  },
  {
    "code": "1.B.3.3",
    "name": "Retail Operations",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengelola operasional seluruh aktivitas retail agar berjalan efektif\n\nTugas dan Tanggung Jawab\n\nMengelola operasional outlet retail\nMenjamin standar layanan pelanggan\nMonitoring performa store/day-to-day operation\nImplementasi SOP retail\nKoordinasi dengan supply chain dan sales",
    "qualification": "Kualifikasi:\nS1 Manajemen, Bisnis, Marketing, atau terkait\n5–10 tahun pengalaman retail operations\nStrong operational leadership & customer service focus",
    "value_chain": "SOP Standar Layanan Outlet & Retail Operation Manual",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.3.3.1",
    "name": "KDKMP Operation",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengelola operasional unit KDKMP (unit retail/koperasi/distribusi mikro)\n\nTugas dan Tanggung Jawab\n\nMengelola aktivitas operasional harian KDKMP\nMonitoring distribusi barang ke unit kecil/anggota\nPengelolaan administrasi operasional\nMenjaga kelancaran supply ke unit mikro",
    "qualification": "Kualifikasi:\nS1 Manajemen/Operasional/Logistik\n3–7 tahun pengalaman operasional koperasi/retail unit\nPaham operasional distribusi & retail micro-network",
    "value_chain": "SOP Operasional Unit KDKMP (koperasi/distribusi mikro)",
    "method_cost": 180000000.0
  },
  {
    "code": "1.B.3.3.2",
    "name": "Field Operation dan SOP Standard",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengawasi implementasi operasional lapangan sesuai SOP\n\nTugas dan Tanggung Jawab\n\nMonitoring operasional field (outlet/agent/distributor)\nImplementasi dan update SOP operasional\nAudit kepatuhan SOP di lapangan\nTraining operasional untuk field team\nMenangani issue operasional lapangan",
    "qualification": "Kualifikasi:\nS1 Manajemen, Teknik Industri, Business Administration\n3–8 tahun pengalaman field operation\nStrong SOP development & enforcement capability",
    "value_chain": "Metodologi Audit Kepatuhan SOP Lapangan & Training Operasional",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.3.4",
    "name": "Sales and Channel Management",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengelola seluruh channel penjualan dan strategi distribusi pasar\n\nTugas dan Tanggung Jawab\n\nMengelola strategi multi-channel sales\nMengembangkan channel distribusi baru\nMenjaga hubungan dengan partner bisnis\nMonitoring performa channel sales\nOptimasi kontribusi tiap channel",
    "qualification": "Kualifikasi:\nS1 Marketing, Manajemen, Bisnis\n5–12 tahun pengalaman sales & channel management\nStrong negotiation & partnership management",
    "value_chain": "Sistem Multi-Channel Sales Strategy, Modern Trade Development, Marketplace Development",
    "method_cost": 22250000000.0
  },
  {
    "code": "1.B.3.4.1",
    "name": "Principal and Strategic Account",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengelola hubungan dengan principal dan key strategic account\n\nTugas dan Tanggung Jawab\n\nMengelola kontrak dengan principal/vendor utama\nNegosiasi pricing & terms\nMenjaga hubungan jangka panjang dengan key account\nMonitoring performa akun strategis",
    "qualification": "Kualifikasi:\nS1 Bisnis, Marketing, Manajemen\n5–10 tahun pengalaman key account management\nStrong negotiation & B2B relationship",
    "value_chain": "Sistem CRM Principal & Key Account Management, Key Account Management",
    "method_cost": 25300000000.0
  },
  {
    "code": "1.B.3.4.2",
    "name": "Ecosystem and UMKM Sourching",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengembangkan ekosistem supplier termasuk UMKM\n\nTugas dan Tanggung Jawab\n\nIdentifikasi dan onboarding UMKM/supplier baru\nPengembangan kapasitas supplier lokal\nIntegrasi UMKM ke supply chain perusahaan\nMonitoring kualitas supplier",
    "qualification": "Kualifikasi:\nS1 Ekonomi, Manajemen, Supply Chain\n3–7 tahun pengalaman sourcing/vendor development\nMemahami UMKM ecosystem & supplier development",
    "value_chain": "Metodologi Onboarding & Pengembangan Kapasitas UMKM/Supplier, Channel Partnership",
    "method_cost": 25180000000.0
  },
  {
    "code": "1.B.3.4.3",
    "name": "Promotion and Pricing Management",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi Utama: Mengelola strategi harga dan promosi untuk meningkatkan penjualan\n\nTugas dan Tanggung Jawab\n\nMenyusun strategi pricing (regular & promo)\nAnalisis efektivitas promosi\nMonitoring margin dan profitabilitas\nKoordinasi dengan sales & marketing\nEvaluasi price elasticity",
    "qualification": "Kualifikasi:\nS1 Marketing, Ekonomi, Statistik\n3–8 tahun pengalaman pricing & promotion analytics\nMenguasai data analysis, pricing strategy, retail math",
    "value_chain": "Metodologi Pricing & Promotion Analytics (price elasticity), Trade Promotion",
    "method_cost": 20220000000.0
  },
  {
    "code": "1.B.4",
    "name": "Direktur Keuangan dan Manajemen Risiko",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Menyusun strategi keuangan perusahaan jangka pendek, menengah, dan panjang.\n- Menjamin likuiditas, solvabilitas, dan kesehatan keuangan perusahaan.\n- Mengendalikan pengelolaan pendanaan, treasury, piutang, akuntansi, perpajakan, anggaran, controller, manajemen risiko, dan kepatuhan.\n- Mengembangkan sistem pengendalian internal dan tata kelola perusahaan (GCG).\n- Mengawasi penyusunan laporan keuangan sesuai standar akuntansi.\n- Mengelola risiko keuangan, operasional, hukum, dan kepatuhan.\n- Memberikan rekomendasi strategis kepada Direksi mengenai investasi, pembiayaan, dan efisiensi biaya.\n- Memastikan kepatuhan terhadap peraturan perpajakan, regulator, dan auditor.",
    "qualification": "Kualifikasi\n- S2/S1 Akuntansi, Keuangan, Manajemen, Ekonomi.\n- Pengalaman minimal 15 tahun di bidang keuangan.\n- Minimal 8 tahun pada level manajerial senior.\n- Memahami Corporate Finance, Treasury, Risk Management, ERP, dan GCG.\n\nKompetensi Teknis\n- Corporate Finance\n- Strategic Financial Management\n- Treasury Management\n- Financial Planning & Analysis\n- Risk Management\n- Corporate Governance\n- IFRS/PSAK\n- Tax Planning\n- Internal Control\n- Business Strategy\n\nSertifikasi\n- CPA\n- CMA\n- CFA\n- FRM\n- CRMP\n- QIA\n- Brevet Pajak A & B (nilai tambah)\n- ISO 31000 Risk Management\n- ISO 37301 Compliance (nilai tambah)",
    "value_chain": "Framework Corporate Finance & Enterprise Risk Governance",
    "method_cost": 350000000.0
  },
  {
    "code": "1.B.4.1",
    "name": "Keuangan",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Mengelola seluruh aktivitas keuangan perusahaan.\n- Menjamin kecukupan dana operasional.\n- Mengendalikan cash flow.\n- Mengoptimalkan struktur pendanaan.",
    "qualification": "Kualifikasi\n- S1 Akuntansi/Keuangan.\n- Pengalaman 10 tahun.\n- Kompetensi Teknis\n- Financial Management\n- Cash Management\n- Banking\n- Financial Analysis\n- Working Capital Management\n\nSertifikasi\n- CMA\n- CFA\n- CPA",
    "value_chain": "Sistem Treasury Management (cash flow, forex, hedging)",
    "method_cost": 450000000.0
  },
  {
    "code": "1.B.4.1.1",
    "name": "Funding",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Menyusun strategi pendanaan.\n- Mengelola pinjaman bank.\n- Menjalin hubungan dengan investor dan lembaga keuangan.\n- Menyiapkan proposal pembiayaan.\n- Mengelola covenant pinjaman.",
    "qualification": "Kualifikasi\n- S1 Keuangan/Akuntansi.\n- Pengalaman 5–8 tahun.\n- Kompetensi Teknis\n- Debt Financing\n- Project Financing\n- Financial Modeling\n- Capital Structure\n- Loan Administration\n\nSertifikasi\n- CFA\n- FMVA\n- CMA",
    "value_chain": "Metodologi Strategi Pendanaan & Covenant Management",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.4.1.2",
    "name": "Treasury",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Mengelola kas perusahaan.\n- Forecast cash flow.\n- Pengelolaan rekening bank.\n- Investasi jangka pendek.\n- Foreign Exchange Management.",
    "qualification": "Kualifikasi\n- S1 Keuangan.\n- Pengalaman Treasury 5 tahun.\n- Kompetensi Teknis\n- Cash Management\n- Liquidity Management\n- Forex\n- Hedging\n- Banking Operations\n\nSertifikasi\n- CTP (Certified Treasury Professional)\n- CFA\n- FMVA",
    "value_chain": "Sistem Cash Management & Investasi Jangka Pendek",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.4.1.3",
    "name": "Collection - Corporate",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Mengelola piutang pelanggan korporasi.\n- Menurunkan overdue.\n- Menyusun strategi collection.\n- Negosiasi pembayaran.\n- Monitoring aging receivable.",
    "qualification": "Kualifikasi\n- S1 Manajemen/Akuntansi.\n- Kompetensi Teknis\n- Credit Control\n- Collection Strategy\n- Negotiation\n- Receivable Management\n- SAP AR\n\nSertifikasi\n- Credit Management Certification\n- Certified Collection Professional",
    "value_chain": "Sistem Credit Control & Collection Strategy Korporat",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.4.1.4",
    "name": "Collection - Retail dan Distribusi",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Mengelola penagihan retail.\n- Monitoring outlet.\n- Pengendalian piutang distributor.\n- Evaluasi kredit pelanggan.",
    "qualification": "Kompetensi Teknis\n- Retail Collection\n- Credit Scoring\n- Collection System\n- Aging Analysis\n\nSertifikasi\n- Credit Management\n- Certified Collection Officer",
    "value_chain": "Sistem Collection & Credit Scoring Retail",
    "method_cost": 180000000.0
  },
  {
    "code": "1.B.4.2",
    "name": "Akuntansi, Pajak, dan Anggaran",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Menjamin penyusunan laporan keuangan.\n- Mengendalikan perpajakan.\n- Mengelola anggaran perusahaan.\n- Menjamin kepatuhan PSAK dan regulasi.",
    "qualification": "Kualifikasi\n- S1 Akuntansi.\n- Pengalaman 10 tahun.\n\nKompetensi Teknis\n- Financial Reporting\n- Tax Management\n- Budget Control\n- ERP Finance\n- Cost Accounting\n\nSertifikasi\n- CPA\n- CMA\n- Brevet Pajak",
    "value_chain": "Modul ERP Finance (GL, Fixed Asset, Budget) sesuai PSAK/IFRS, ERP SAP S/4HANA",
    "method_cost": 40600000000.0
  },
  {
    "code": "1.B.4.2.1",
    "name": "Akuntansi",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Menyusun laporan keuangan.\n- Closing bulanan.\n- Rekonsiliasi.\n- General Ledger.\n- Fixed Asset.",
    "qualification": "Kompetensi Teknis\n- PSAK\n- IFRS\n- General Ledger\n- Financial Reporting\n- ERP\n\nSertifikasi\n- CPA\n- CA Indonesia",
    "value_chain": "SOP Closing Bulanan, Rekonsiliasi & General Ledger",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.4.2.2",
    "name": "Pajak",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Mengelola seluruh kewajiban perpajakan.\n- Tax planning.\n- Tax audit.\n- Tax compliance.",
    "qualification": "Kompetensi Teknis\n- PPh\n- PPN\n- Transfer Pricing\n- Coretax\n- Tax Planning\n\nSertifikasi\n- Brevet A\n- Brevet B\n- Brevet C\n- CTP (Certified Tax Professional)",
    "value_chain": "Sistem Perpajakan (Coretax integration & tax planning)",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.4.2.3",
    "name": "Pengendalian Anggaran",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Menyusun RKAP.\n- Monitoring realisasi anggaran.\n- Analisis varians.\n- Forecast.",
    "qualification": "Kompetensi Teknis\n- Budget Planning\n- Budget Monitoring\n- Variance Analysis\n- Cost Control\n\nSertifikasi\n- CMA\n- FMVA",
    "value_chain": "Sistem RKAP & Variance Analysis Budget, FP&A Dashboard",
    "method_cost": 12180000000.0
  },
  {
    "code": "1.B.4.3",
    "name": "Controller",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Mengendalikan biaya perusahaan.\n- Monitoring profitabilitas.\n- Revenue assurance.\n- Analisis biaya.",
    "qualification": "Kualifikasi\n- S1 Akuntansi.\n- Pengalaman Controller minimal 8 tahun.\n\nKompetensi Teknis\n- Cost Control\n- Business Control\n- Financial Analysis\n- Internal Control\n\nSertifikasi\n- CMA\n- CPA",
    "value_chain": "Sistem Cost Control & Business Control (financial analysis)",
    "method_cost": 300000000.0
  },
  {
    "code": "1.B.4.3.1",
    "name": "Billing",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Mengelola proses penagihan.\n- Validasi invoice.\n- Rekonsiliasi billing.\n- Monitoring outstanding invoice.",
    "qualification": "Kompetensi Teknis\n- Billing System\n- Invoicing\n- Revenue Recognition\n- SAP SD/FI\n\nSertifikasi\n- SAP Finance (nilai tambah)",
    "value_chain": "Sistem Billing & Invoicing (revenue recognition)",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.4.3.2",
    "name": "Pengendalian Biaya - Unit",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Monitoring biaya setiap unit.\n- Analisis efisiensi.\n- Evaluasi cost center.\n- Penyusunan KPI biaya.",
    "qualification": "Kompetensi Teknis\n- Cost Accounting\n- Cost Analysis\n- Budget Control\n- Activity Based Costing\n\nSertifikasi\n- CMA",
    "value_chain": "Metodologi Activity Based Costing per cost center",
    "method_cost": 180000000.0
  },
  {
    "code": "1.B.4.3.3",
    "name": "Revenue Assurance - Pengendalian Biaya Corporate",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Menjamin seluruh pendapatan tercatat.\n- Mengidentifikasi revenue leakage.\n- Audit pendapatan.\n- Pengendalian biaya korporasi.",
    "qualification": "Kompetensi Teknis\n- Revenue Assurance\n- Fraud Detection\n- Internal Control\n- Business Process Review\n\nSertifikasi\n- CRMA\n- CFE\n- QIA",
    "value_chain": "Sistem Revenue Assurance & Fraud Detection",
    "method_cost": 220000000.0
  },
  {
    "code": "1.B.4.4",
    "name": "Manajemen Risiko & Kepatuhan",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Mengembangkan Enterprise Risk Management (ERM).\n- Menjamin kepatuhan terhadap regulasi.\n- Mengelola risk register.\n- Monitoring mitigasi risiko.\n- Mengembangkan budaya kepatuhan.",
    "qualification": "Kualifikasi\n- S1 Manajemen, Akuntansi, Hukum, atau Teknik.\n- Pengalaman minimal 8–10 tahun di bidang risiko, audit, atau kepatuhan.\n\nKompetensi Teknis\n- Enterprise Risk Management\n- Compliance Management\n- GRC (Governance, Risk & Compliance)\n- Internal Control\n- Risk Assessment\n- Regulatory Compliance\n\nSertifikasi\n- CRMP\n- FRM\n- ISO 31000 Risk Management\n- ISO 37301 Compliance\n- QIA\n- CIA",
    "value_chain": "Sistem GRC (Governance, Risk & Compliance)",
    "method_cost": 400000000.0
  },
  {
    "code": "1.B.4.4.1",
    "name": "Manajemen Risiko",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Identifikasi risiko perusahaan.\n- Risk assessment.\n- Menyusun risk register.\n- Monitoring Key Risk Indicator (KRI).\n- Menyusun mitigasi risiko.",
    "qualification": "Kompetensi Teknis\n- ISO 31000\n- COSO ERM\n- Risk Assessment\n- Risk Quantification\n- Business Continuity Management\n\nSertifikasi\n- CRMP\n- FRM\n- ISO 31000 Lead Risk Manager",
    "value_chain": "Sertifikasi ISO 31000 & Enterprise Risk Management (risk register/KRI), Enterprise Risk Management",
    "method_cost": 5220000000.0
  },
  {
    "code": "1.B.4.4.2",
    "name": "Manajemen Kepatuhan",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab\n- Memastikan kepatuhan terhadap regulasi.\n- Monitoring implementasi SOP.\n- Mengelola audit kepatuhan.\n- Sosialisasi kebijakan perusahaan.\n- Menyusun laporan kepatuhan.",
    "qualification": "Kompetensi Teknis\n- Compliance Management\n- Regulatory Mapping\n- GCG\n- Internal Control\n- Anti-Bribery Management\n- Governance Framework\n\nSertifikasi\n- ISO 37301 Compliance Management\n- ISO 37001 Anti-Bribery Management System\n- Certified Compliance Professional (CCP)\n- QIA\n- CIA",
    "value_chain": "Sertifikasi ISO 37001 (SMAP) & Compliance Monitoring",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.5",
    "name": "Direktur Teknik dan Konsultan Enjiniring",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMenetapkan strategi, kebijakan, dan sasaran kinerja Direktorat sejalan dengan RJP dan RKAP Korporat, termasuk target implementasi EBITDAMAX\n•\tMengarahkan, mengawasi, dan mengevaluasi kinerja seluruh Divisi di bawahnya (Teknik, Pemasaran, Operasional, Kantor Wilayah, PPC)\n•\tMemastikan penerapan Sistem Manajemen Mutu, K3L, dan Anti-Penyuapan pada seluruh proses bisnis Direktorat\n•\tMemimpin Management Review Meeting tingkat Direktorat secara berkala\n•\tMembangun dan memelihara hubungan strategis dengan pelanggan, pemerintah, mitra kerja, dan pemangku kepentingan lainnya\n•\tBertanggung jawab atas pencapaian target pendapatan, EBITDA, kualitas produk/jasa, dan kepuasan pelanggan Direktorat\n•\tMelakukan pembinaan, pengembangan kompetensi, dan regenerasi kepemimpinan SDM di lingkungan Direktorat\n•\tMenyampaikan laporan kinerja dan usulan strategis Direktorat kepada Direksi/Dewan Pengarah",
    "qualification": "Kompetensi Teknis:\n•\tPendidikan minimal S1 Teknik (Sipil/Arsitektur/Industri) diutamakan S2 Teknik atau Manajemen\n•\tPengalaman kerja minimal 15 tahun di bidang konstruksi, EPC, atau konsultan enjiniring, dengan minimal 5 tahun pada posisi manajerial senior (VP/GM ke atas)\n•\tMemiliki Sertifikat Keahlian (SKA) Ahli Utama sesuai bidang keteknikan\n•\tMemahami manajemen proyek berbasis PMBOK/IPMA serta perencanaan strategis korporat (RJP/RKAP)\n•\tMemahami penerapan Sistem Manajemen Terintegrasi (ISO 9001, ISO 14001, ISO 45001, ISO 37001)\n•\tMemiliki kemampuan kepemimpinan, negosiasi tingkat tinggi, dan relasi dengan pemerintah/BUMN/mitra strategis\n•\tRekam jejak bebas dari pelanggaran integritas dan kepatuhan anti-penyuapan",
    "value_chain": "Framework EBITDAMAX & Sistem Manajemen Terintegrasi (mutu-K3L-anti suap)",
    "method_cost": 400000000.0
  },
  {
    "code": "1.B.5.1",
    "name": "Teknik",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMengoordinasikan pelaksanaan tugas Sub Divisi Design, Perencanaan, dan Manajemen Konstruksi\n•\tMenetapkan standar mutu teknis dan memastikan kesesuaiannya dengan persyaratan pelanggan dan regulasi\n•\tMelakukan quality control dan quality assurance terhadap seluruh produk enjiniring (gambar, dokumen perencanaan, laporan pengawasan)\n•\tMengendalikan sumber daya teknis (tenaga ahli, software, peralatan) pada setiap proyek\n•\tMelakukan evaluasi dan penyempurnaan metode kerja teknik secara berkelanjutan\n•\tBerkoordinasi dengan Divisi Pemasaran dalam penyusunan aspek teknis proposal dan estimasi\n•\tBerkoordinasi dengan Divisi Operasional dalam pelaksanaan proyek di lapangan",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik Sipil/Arsitektur, diutamakan S2 Teknik\n•\tPengalaman minimal 10-12 tahun di bidang jasa konsultansi enjiniring, dengan minimal 3-5 tahun pada posisi manajerial\n•\tMemiliki SKA Madya/Utama sesuai bidang keahlian\n•\tMenguasai standar desain, spesifikasi teknis, metode perencanaan, serta manajemen konstruksi\n•\tMemahami regulasi teknis bangunan/infrastruktur dan sistem manajemen mutu ISO 9001",
    "value_chain": "Sertifikasi ISO 9001 (Mutu) Jasa Konsultansi Enjiniring",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.5.1.1",
    "name": "Design",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMenyusun gambar rancangan (skematik, desain awal, detail engineering design/DED)\n•\tMenyusun spesifikasi teknis dan Bill of Quantity (BQ) pendukung desain\n•\tMelakukan koordinasi desain multidisiplin (arsitektur, struktur, mekanikal-elektrikal)\n•\tMelakukan review dan revisi desain berdasarkan masukan pelanggan atau hasil perencanaan\n•\tMemastikan produk desain sesuai kaidah keselamatan bangunan dan efisiensi biaya\n•\tMendokumentasikan seluruh produk desain sesuai prosedur pengendalian dokumen",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik Arsitektur/Sipil\n•\tPengalaman minimal 7-10 tahun di bidang desain bangunan/infrastruktur\n•\tMenguasai perangkat lunak CAD dan BIM (AutoCAD, Revit, atau setara)\n•\tMemiliki SKA Muda/Madya bidang arsitektur/struktur\n•\tMemahami standar perancangan, kode bangunan, dan spesifikasi teknis",
    "value_chain": "Software CAD/BIM (AutoCAD, Revit) untuk DED",
    "method_cost": 300000000.0
  },
  {
    "code": "1.B.5.1.2",
    "name": "Perencanaan",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMelaksanakan survei, investigasi, dan identifikasi kebutuhan proyek (topografi, geoteknik, hidrologi, dan sebagainya)\n•\tMenyusun studi kelayakan (feasibility study) termasuk kajian teknis, lingkungan, dan finansial\n•\tMenyusun Rencana Anggaran Biaya (RAB) dan Rencana Mutu Proyek\n•\tMelakukan koordinasi dengan instansi terkait perizinan dan regulasi perencanaan\n•\tMenyusun dokumen perencanaan sebagai dasar pelaksanaan tender dan konstruksi\n•\tMelakukan evaluasi hasil perencanaan pasca pelaksanaan proyek untuk perbaikan ke depan",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik Sipil/Planologi/Lingkungan\n•\tPengalaman minimal 7-10 tahun di bidang perencanaan/studi kelayakan proyek\n•\tMenguasai metode studi makro, studi detail, dan Analisa Mengenai Dampak Lingkungan (AMDAL)\n•\tMenguasai penyusunan Rencana Anggaran Biaya (RAB) dan kajian kelayakan finansial\n•\tMemiliki SKA Muda/Madya bidang perencanaan wilayah/teknik sipil",
    "value_chain": "Metodologi Studi Kelayakan (feasibility study & AMDAL)",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.5.1.3",
    "name": "Manajemen Konstruksi",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMelakukan pengawasan pelaksanaan konstruksi di lapangan agar sesuai gambar dan spesifikasi\n•\tMengendalikan mutu, biaya, dan waktu pelaksanaan proyek (cost-quality-time control)\n•\tMelakukan evaluasi metode kerja kontraktor/pelaksana dan memberikan rekomendasi perbaikan\n•\tMenyusun laporan kemajuan pekerjaan (progress report) secara berkala\n•\tMengidentifikasi dan mengelola risiko pelaksanaan konstruksi termasuk K3 di lapangan\n•\tMelakukan koordinasi dengan Divisi Operasional dan pihak owner/pelanggan terkait progres proyek",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik Sipil\n•\tPengalaman minimal 7-10 tahun sebagai pengawas/manajemen konstruksi proyek\n•\tMemiliki SKA Madya Manajemen Konstruksi/Pengawasan\n•\tMenguasai pengendalian mutu, biaya, dan waktu (cost-quality-time control) pelaksanaan konstruksi\n•\tMemahami metode kerja konstruksi dan aspek K3 konstruksi",
    "value_chain": "Metodologi Cost-Quality-Time Control Konstruksi",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.5.2",
    "name": "Pemasaran",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMenetapkan strategi pemasaran dan target perolehan kontrak baru sejalan dengan RKAP Direktorat\n•\tMengoordinasikan kegiatan tender, proposal, hubungan pelanggan, dan kemitraan strategis\n•\tMenganalisis peluang pasar dan pesaing sebagai dasar penetapan strategi bersaing\n•\tMemastikan pemenuhan kepuasan pelanggan dan penanganan keluhan secara efektif\n•\tMembangun dan memelihara jejaring kemitraan strategis (KSO/JO) dengan mitra domestik dan internasional\n•\tMelaporkan pencapaian target pemasaran kepada Direktur secara berkala",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik/Ekonomi/Manajemen, diutamakan S2\n•\tPengalaman minimal 10-12 tahun di bidang pemasaran/business development jasa konstruksi/konsultansi\n•\tMenguasai proses tender pemerintah/BUMN (e-procurement/LPSE) dan penyusunan proposal\n•\tMemiliki jaringan relasi yang luas dengan pelanggan, pemerintah, dan mitra bisnis\n•\tMemahami analisis pasar, strategi bersaing, dan manajemen kepuasan pelanggan",
    "value_chain": "Metodologi Tender & Proposal (e-Procurement/LPSE)",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.5.2.1",
    "name": "Tender dan Proposal",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMenerima dan menelaah undangan tender serta dokumen persyaratannya\n•\tMelakukan peninjauan lokasi, ketersediaan sumber daya, dan analisis pesaing\n•\tMenyusun estimasi biaya dan dokumen proposal/penawaran\n•\tMelakukan klarifikasi dan negosiasi dengan pemberi kerja\n•\tMenyusun dan mengawal proses administrasi kontrak hingga penandatanganan\n•\tMengevaluasi hasil tender (menang/kalah) untuk perbaikan strategi ke depan",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik/Ekonomi\n•\tPengalaman minimal 7-10 tahun dalam penyusunan dokumen tender dan estimasi biaya\n•\tMenguasai sistem pengadaan elektronik (LPSE/e-procurement) dan regulasi pengadaan barang/jasa\n•\tMenguasai teknik estimasi biaya (engineer's estimate) dan negosiasi kontrak",
    "value_chain": "Sistem Estimasi Biaya (engineer's estimate) & Dokumen Penawaran",
    "method_cost": 180000000.0
  },
  {
    "code": "1.B.5.2.2",
    "name": "Customer Relations",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMelakukan survei dan evaluasi tingkat kepuasan pelanggan secara berkala\n•\tMenerima, mencatat, dan menindaklanjuti keluhan pelanggan hingga tuntas\n•\tMenjalin komunikasi rutin dengan pelanggan eksisting untuk peluang repeat order\n•\tMenyusun laporan hasil evaluasi kepuasan pelanggan dan rencana tindak lanjut perbaikan\n•\tBerkoordinasi dengan Divisi Operasional dalam pemenuhan kebutuhan/ekspektasi pelanggan selama pelaksanaan proyek",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 semua jurusan relevan (Teknik/Komunikasi/Manajemen)\n•\tPengalaman minimal 5-7 tahun di bidang customer service/account management\n•\tMemiliki kemampuan komunikasi, negosiasi, dan penanganan keluhan pelanggan yang baik\n•\tMemahami produk/jasa konsultan enjiniring perusahaan",
    "value_chain": "Sistem Customer Satisfaction Survey & Penanganan Keluhan",
    "method_cost": 150000000.0
  },
  {
    "code": "1.B.5.2.3",
    "name": "Kemitraan Strategis & Market Intelegence",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMelakukan riset dan analisis pasar, pesaing, serta tren industri secara berkala\n•\tMengidentifikasi dan mengevaluasi peluang kemitraan strategis (KSO/JO) domestik maupun internasional\n•\tMenyusun kajian kelayakan kemitraan dan rekomendasi skema kerja sama\n•\tMembangun dan memelihara komunikasi dengan calon mitra strategis\n•\tMenyusun laporan market intelligence sebagai masukan strategi pemasaran dan pengembangan bisnis",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik/Ekonomi/Bisnis, diutamakan S2\n•\tPengalaman minimal 7-10 tahun di bidang business development/riset pasar\n•\tMenguasai analisis SWOT, benchmarking, dan penyusunan skema kerja sama (KSO/JO/kemitraan)\n•\tMemahami tren industri konstruksi dan enjiniring nasional maupun regional",
    "value_chain": "Metodologi Market Intelligence & Skema KSO/JO",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.5.3",
    "name": "Operasional",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMenetapkan rencana dan target kinerja operasional Divisi sejalan dengan RKAP\n•\tMengoordinasikan pelaksanaan proyek pada seluruh Sub Divisi Operasional\n•\tMelakukan pengendalian biaya, mutu, dan waktu (cost-quality-time) pada seluruh proyek berjalan\n•\tMengidentifikasi dan mengelola risiko operasional termasuk risiko K3L dan penyuapan\n•\tMelakukan evaluasi kinerja operasional dan menetapkan tindak lanjut penyempurnaan\n•\tMelaporkan kinerja operasional Direktorat secara berkala kepada Direktur",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik Sipil/Arsitektur, diutamakan S2\n•\tPengalaman minimal 10-12 tahun dalam manajemen operasi proyek konstruksi/enjiniring\n•\tMemiliki SKA Utama dan pengalaman sebagai Project Manager pada proyek besar\n•\tMenguasai pengendalian biaya, mutu, waktu proyek, serta manajemen risiko operasional",
    "value_chain": "Metodologi Manajemen Proyek (cost-quality-time) + Primavera/MS Project",
    "method_cost": 350000000.0
  },
  {
    "code": "1.B.5.3.1",
    "name": "Building Management",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•        Menyusun rencana pengelolaan dan pemeliharaan aset gedung\n•        Mengendalikan operasional fasilitas gedung (utilitas, keamanan, kebersihan, dan sebagainya)\n•        Melakukan pemantauan kondisi bangunan dan menyusun rencana perbaikan/pemeliharaan berkala\n•        Mengelola hubungan dengan penyewa/pengguna gedung terkait kebutuhan operasional\n•        Menyusun laporan kinerja pengelolaan gedung dan realisasi biaya operasional",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik Sipil/Arsitektur/Manajemen Properti\n•\tPengalaman minimal 7-10 tahun di bidang building/property/facility management\n•\tMenguasai pengelolaan aset gedung, pemeliharaan fasilitas, dan manajemen penyewa/pengguna gedung\n•\tMemahami aspek keselamatan gedung dan efisiensi biaya operasional bangunan",
    "value_chain": "Sistem Manajemen Aset Gedung & Facility Management",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.5.3.2",
    "name": "Engineering",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMemberikan dukungan teknis (technical support) kepada tim pelaksana proyek\n•\tMelakukan kajian value engineering untuk optimalisasi biaya dan mutu pekerjaan\n•\tMenyelesaikan permasalahan teknis lapangan yang memerlukan penyesuaian desain/metode kerja\n•\tMelakukan koordinasi dengan Divisi Teknik terkait perubahan desain akibat kondisi lapangan\n•\tMenyusun dokumentasi solusi teknis (lesson learned) untuk proyek berikutnya",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik Sipil/Mesin/Elektro\n•\tPengalaman minimal 7-10 tahun dalam dukungan teknis pelaksanaan proyek\n•\tMemiliki SKA Madya sesuai bidang keahlian\n•\tMenguasai value engineering dan problem solving teknis di lapangan",
    "value_chain": "Metodologi Value Engineering & Technical Support Lapangan",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.5.3.3",
    "name": "Infrastruktur",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMengelola pelaksanaan proyek infrastruktur (jalan, jembatan, irigasi, sumber daya air, dan sebagainya)\n•\tMelakukan koordinasi dengan pemerintah/instansi terkait perizinan dan pengawasan proyek infrastruktur\n•\tMengendalikan biaya, mutu, dan waktu pelaksanaan proyek infrastruktur\n•\tMengelola risiko teknis dan sosial pada proyek infrastruktur (pembebasan lahan, dampak lingkungan)\n•\tMenyusun laporan kemajuan dan kinerja proyek infrastruktur secara berkala",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik Sipil\n•\tPengalaman minimal 7-10 tahun pada proyek infrastruktur (jalan, jembatan, sumber daya air, irigasi)\n•\tMemiliki SKA Madya bidang Sumber Daya Air/Jalan-Jembatan\n•\tMemahami regulasi dan koordinasi dengan instansi pemerintah terkait infrastruktur",
    "value_chain": "Metodologi Pengelolaan Proyek Infrastruktur (jalan/jembatan/irigasi)",
    "method_cost": 300000000.0
  },
  {
    "code": "1.B.5.3.5",
    "name": "Gedung",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMengelola pelaksanaan proyek pembangunan gedung (kantor, pabrik, hotel, fasilitas pendidikan, dan sebagainya)\n•\tMengoordinasikan pekerjaan multidisiplin (struktur, arsitektur, mekanikal-elektrikal-plumbing) di lapangan\n•\tMengendalikan biaya, mutu, dan waktu pelaksanaan proyek gedung\n•\tMelakukan koordinasi dengan owner/pelanggan terkait progres dan serah terima pekerjaan\n•\tMenyusun laporan kemajuan dan kinerja proyek gedung secara berkala",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik Sipil/Arsitektur\n•\tPengalaman minimal 7-10 tahun pada proyek pembangunan gedung (kantor, pabrik, fasilitas publik)\n•\tMemiliki SKA Madya bidang Bangunan Gedung\n•\tMenguasai pengendalian proyek gedung bertingkat dan koordinasi multidisiplin (struktur, arsitektur, MEP)",
    "value_chain": "Metodologi Koordinasi Multidisiplin Proyek Gedung (struktur-arsitektur-MEP)",
    "method_cost": 300000000.0
  },
  {
    "code": "1.B.5.3.4",
    "name": "Pemukiman & Pengembangan",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMengelola pelaksanaan proyek permukiman kembali (resettlement) dan pengembangan kawasan/wilayah\n•\tMelakukan koordinasi dengan pemerintah daerah dan masyarakat terdampak proyek\n•\tMengendalikan biaya, mutu, dan waktu pelaksanaan proyek permukiman & pengembangan\n•\tMengelola risiko sosial dan lingkungan yang timbul selama pelaksanaan proyek\n•\tMenyusun laporan kemajuan dan kinerja proyek secara berkala",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik Sipil/Planologi\n•\tPengalaman minimal 7-10 tahun pada proyek permukiman, resettlement, atau pengembangan kawasan\n•\tMemiliki SKA Madya bidang Perencanaan Wilayah/Teknik Sipil\n•\tMemahami aspek sosial-kemasyarakatan dalam pengembangan kawasan dan permukiman",
    "value_chain": "Metodologi Pengelolaan Proyek Resettlement & Pengembangan Kawasan",
    "method_cost": 250000000.0
  },
  {
    "code": "1.B.5.4",
    "name": "Kantor Wilayah",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMenyusun rencana kerja dan anggaran (RKW) Kantor Wilayah sejalan dengan RKAP Korporat\n•\tMengoordinasikan kegiatan pemasaran, estimasi, tender, dan operasional proyek di wilayah kerja\n•\tMengelola sumber daya manusia, keuangan, dan aset di Kantor Wilayah/Cabang\n•\tMemastikan penerapan Sistem Manajemen Terintegrasi (mutu, K3L, anti-penyuapan) di seluruh proyek wilayah\n•\tMembangun hubungan dengan pemerintah daerah, pelanggan, dan mitra kerja setempat\n•\tMelaporkan kinerja Kantor Wilayah secara berkala kepada Direktur Teknik dan Konsultan Enjiniring",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik, diutamakan S2 Teknik/Manajemen\n•\tPengalaman minimal 10-12 tahun di bidang konstruksi/konsultansi, termasuk pernah menjabat sebagai Project Manager\n•\tMemiliki SKA Madya/Utama sesuai bidang keahlian\n•\tMemahami kondisi bisnis, regulasi, dan karakteristik pasar di wilayah operasi\n•\tMemiliki kemampuan kepemimpinan dan pengelolaan tim lintas fungsi di tingkat regional",
    "value_chain": "SOP & Sistem Pelaporan RKW (Rencana Kerja Wilayah)",
    "method_cost": 200000000.0
  },
  {
    "code": "1.B.5.5",
    "name": "Production Planning and Control",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Tugas dan Tanggung Jawab:\n•\tMenyusun perencanaan dan penjadwalan proyek secara terintegrasi (multi-project scheduling) di lingkup Direktorat\n•\tMengendalikan alokasi dan pemanfaatan sumber daya (tenaga ahli, peralatan, material) antar proyek\n•\tMemantau progres seluruh proyek Direktorat dan mengidentifikasi potensi keterlambatan/penyimpangan\n•\tMenyusun laporan kinerja produksi/proyek secara berkala untuk bahan Management Review Meeting\n•\tMelakukan analisis kapasitas dan rekomendasi optimalisasi beban kerja unit-unit operasional\n•\tBerkoordinasi dengan Divisi Teknik, Pemasaran, dan Operasional dalam penyusunan rencana kerja terpadu",
    "qualification": "Kpmpetensi Teknis:\n•\tS1 Teknik Industri/Teknik Sipil, diutamakan S2\n•\tPengalaman minimal 7-10 tahun dalam perencanaan dan pengendalian produksi/multi-proyek\n•\tMenguasai teknik penjadwalan proyek (Critical Path Method, S-Curve, Primavera/MS Project)\n•\tMenguasai analisis kapasitas sumber daya dan pengendalian kinerja produksi\n•\tMemahami sistem pelaporan kinerja berbasis KPI",
    "value_chain": "Sistem Penjadwalan Multi-Proyek (Critical Path Method/S-Curve/Primavera)",
    "method_cost": 300000000.0
  },
  {
    "code": "1.C.1",
    "name": "SVP Corporate Secretary",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Pemimpin tertinggi Sekretariat Perusahaan yang bertindak sebagai penghubung (liaison officer) utama antara Perusahaan dengan Dewan Komisaris, Pemegang Saham, Regulator, Media, dan Masyarakat, serta menjamin kepatuhan seluruh organ perseroan terhadap aspek hukum korporasi.\n\nTugas & Tanggung Jawab:\n\n- Memastikan penyelenggaraan Rapat Umum Pemegang Saham (RUPS), Rapat Direksi, dan Rapat Dewan Komisaris berjalan sah sesuai regulasi dan hukum yang berlaku.\n\n- Mengoordinasikan strategi komunikasi korporat dan manajemen krisis reputasi bersama tim Humas.\n\n- Mengawasi pengelolaan operasional kantor pusat, pengadaan kebutuhan kerja, dan manajemen aset umum bersama tim Umum.\n\n- Memberikan masukan dan opini kepatuhan tata kelola (corporate governance compliance) kepada Direksi.",
    "qualification": "Kualifikasi Jabatan:\n\nMinimal S1 Hukum, Komunikasi, Manajemen, atau Hubungan Internasional (S2 Hukum Bisnis atau Corporate Governance lebih disukai).\n\nPengalaman kerja minimal 12–15 tahun di bidang kesekretariatan korporat, corporate governance, atau hubungan investor, dengan minimal 5 tahun di level pimpinan senior (VP/SVP).\n\nMemiliki sertifikasi profesi Sekretaris Perusahaan yang sah (seperti ICSP atau ICSA).\n\nMemahami secara mendalam UU Perseroan Terbatas (UU PT), regulasi keterbukaan informasi, dan prinsip GCG.",
    "value_chain": "Sistem Corporate Governance (RUPS/Rapat Direksi) & Manajemen Krisis Reputasi",
    "method_cost": 300000000.0
  },
  {
    "code": "1.C.1.1",
    "name": "Sekretaris Direksi",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Menyediakan dukungan administratif, penjadwalan, koordinasi, dan fasilitasi operasional harian bagi jajaran Direksi untuk memastikan efektivitas kerja kepemimpinan perusahaan.\n\nTugas & Tanggung Jawab:\n\n- Mengelola kalender kerja, agenda rapat, pengaturan perjalanan dinas, dan akomodasi jajaran Direksi.\n\n- Menyaring, memprioritaskan, dan mendistribusikan surat masuk, dokumen persetujuan (approval), maupun panggilan telepon yang ditujukan kepada Direksi.\n\n- Menyusun draf korespondensi resmi, memorandum, atau nota dinas keluar atas nama Direksi.\n\n- Menyiapkan logistik rapat Direksi (ruangan, materi presentasi, konsumsi) dan menyusun Risalah Rapat (Minutes of Meeting).",
    "qualification": "Kualifikasi Jabatan:\n\nMinimal D3/S1 Sekretaris, Administrasi Bisnis, Komunikasi, atau Ilmu Hukum.\n\nPengalaman kerja minimal 3–5 tahun sebagai sekretaris eksekutif, asisten pribadi direksi, atau executive assistant di korporasi berskala menengah-besar.\n\nMemiliki kemampuan interpersonal yang sangat baik, rapi, cekatan, dan memiliki integritas tinggi dalam menjaga kerahasiaan data korporasi (high confidentiality).\n\nFasih menggunakan perangkat kerja digital (Google Workspace/MS Office) dan memiliki kemampuan korespondensi bisnis formal (Bahasa Indonesia & Inggris).",
    "value_chain": "Sistem Manajemen Agenda & Korespondensi Direksi",
    "method_cost": 120000000.0
  },
  {
    "code": "1.C.1.2",
    "name": "Humas",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Merancang dan mengeksekusi program komunikasi korporat untuk membangun, memelihara, dan melindungi citra, reputasi, serta hubungan baik antara perusahaan dengan pemangku kepentingan eksternal (publik dan media).\n\nTugas & Tanggung Jawab:\n\nMenyusun dan menyebarkan siaran pers (press release) resmi perusahaan ke media massa terkait kegiatan atau isu korporasi.\n\nMelakukan pemantauan media (media monitoring) harian dan analisis sentimen terhadap pemberitaan yang menyangkut nama perusahaan.\n\nMengembangkan, memelihara, dan memperbarui konten informasi pada kanal komunikasi resmi perusahaan (website dan media sosial resmi).\n\nMenjadi garda depan pelaksana teknis dalam manajemen krisis komunikasi jika terjadi isu negatif di publik.",
    "qualification": "Kualifikasi Jabatan:\n\nMinimal S1 Ilmu Komunikasi, Hubungan Masyarakat, Jurnalistik, atau Hubungan Internasional.\n\nPengalaman kerja minimal 3–6 tahun di bidang Public Relations (PR), Media Relations, atau manajemen reputasi korporat.\n\nMemiliki jaringan (networking) yang luas dengan media massa, jurnalis, dan agensi komunikasi.\n\nMahir dalam menulis siaran pers (press release writing), manajemen media sosial korporat, dan memiliki kemampuan komunikasi publik yang persuasif.",
    "value_chain": "Platform Media Monitoring & Press Release Management",
    "method_cost": 180000000.0
  },
  {
    "code": "1.C.1.3",
    "name": "Umum",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Mengelola operasional sarana, prasarana, fasilitas, perizinan umum, dan pelayanan rumah tangga kantor pusat untuk menciptakan lingkungan kerja yang aman, nyaman, dan mendukung produktivitas seluruh karyawan.\n\nTugas & Tanggung Jawab:\n\nMelakukan pengadaan dan kontrol stok alat tulis kantor (ATK), seragam, serta kebutuhan operasional harian kantor pusat.\n\nMengurus legalitas hukum operasional umum harian, seperti perpanjangan pajak kendaraan dinas, asuransi gedung, dan izin gangguan lokal.\n\nMengawasi kinerja pihak ketiga (outsourcing vendor) seperti penyedia tenaga kebersihan, katering, atau kurir logistik.",
    "qualification": "Kualifikasi Jabatan:\n\nMinimal S1 Manajemen, Administrasi Bisnis, Teknik, atau bidang terkait.\n\nPengalaman kerja minimal 4–6 tahun di bidang General Affairs (GA), operasional kantor, atau manajemen aset/fasilitas.\n\nMemahami manajemen pengadaan barang (procurement), negosiasi vendor, perawatan gedung (facility management), serta perizinan umum (domisili, kendaraan dinas, dll).\n\nTegas, cekatan, memiliki kemampuan kepemimpinan lapangan, dan berorientasi pada pemecahan masalah (problem solving).",
    "value_chain": "SOP General Affairs Kantor Pusat",
    "method_cost": 130000000.0
  },
  {
    "code": "1.C.2",
    "name": "SVP Legal",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Pemimpin tertinggi aspek hukum korporasi yang bertanggung jawab merancang strategi mitigasi risiko hukum, mengawal transaksi bisnis strategis , dan membentengi hak-hak hukum perusahaan di dalam maupun luar pengadilan.\n\nTugas & Tanggung Jawab:\n●Merumuskan kebijakan, pedoman standardisasi kontrak, dan arsitektur mitigasi risiko hukum komersial di seluruh lini perusahaan.\n●Memberikan pendapat hukum tertinggi (legal opinion) kepada Direksi sebelum keputusan diambil.\n●Memimpin negosiasi kontrak strategis/internasional yang sensitif dan bernilai material bagi kelangsungan bisnis.\n●Mengendalikan dan mengevaluasi strategi penanganan sengketa (dispute) hukum berskala besar (litigasi perdata/pidana, perburuhan, atau arbitrase).",
    "qualification": "Kualifikasi Jabatan:\n\nMinimal S1 Hukum (S2 Hukum Bisnis atau Hukum Korporasi menjadi nilai tambah utama).\n\nMemiliki Lisensi Advokat aktif (PERADI atau asosiasi resmi yang setara).\n\nPengalaman kerja minimal 12–15 tahun di korporasi multi-nasional atau top-tier law firm, dengan rekam jejak kuat \npada aspek Contract Lifecycle Management, litigasi kompleks, restrukturisasi aset, serta hukum ketenagakerjaan.",
    "value_chain": "Sistem Contract Lifecycle Management & Legal Risk Framework",
    "method_cost": 350000000.0
  },
  {
    "code": "1.C.2.1",
    "name": "Legal",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Menyediakan dukungan teknis, analisis, dan eksekusi operasional hukum harian (day-to-day legal support) untuk seluruh divisi operasional.\n\nTugas & Tanggung Jawab:\n●Melakukan pembuatan draf dan tinjauan (drafting & reviewing) atas seluruh perjanjian kerja sama, NDA, kontrak vendor, dan dokumen transaksi komersial harian.\n●Mengurus pembuatan, perpanjangan, dan pembaruan seluruh dokumen perizinan usaha, hak kekayaan intelektual (HAKI), serta lisensi operasional unit bisnis.\n●Melakukan riset mendalam (legal research) terhadap peraturan perundang-undangan baru yang berpotensi memengaruhi jalannya operasional bisnis.\nMenangani penataan administrasi klaim, somasi awal, atau keberatan hukum skala ringan hingga menengah dari pihak ketiga.",
    "qualification": "Kualifikasi Jabatan: \n\nMinimal S1 Hukum, pengalaman kerja 3–6 tahun sebagai Legal Officer/Corporate Legal. \n\nMemiliki keahlian mumpuni dalam legal drafting (perancangan kontrak multibahasa), riset hukum, dan pengoperasian sistem perizinan pemerintah (OSS RBA / LKPM).",
    "value_chain": "Sistem Legal Drafting & Database Riset Hukum, Contract Management System",
    "method_cost": 4250000000.0
  },
  {
    "code": "1.C.3",
    "name": "VP Internal Audit",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Mengendalikan fungsi pengawasan independen dan objektif guna mengevaluasi serta memberikan rekomendasi perbaikan atas efektivitas manajemen risiko, sistem pengendalian internal (internal control), dan kepatuhan terhadap SOP operasional/keuangan perusahaan.\n\nTugas & Tanggung Jawab:\n●Menyusun dan menetapkan Rencana Kerja Audit Internal Tahunan (PKAT) berbasis manajemen risiko (Risk-based Annual Audit Plan).\n●Melaporkan hasil temuan audit kritis secara berkala dan independen langsung kepada Direktur Utama dan Komite Audit.\n●Memimpin pelaksanaan investigasi khusus atas indikasi kecurangan (fraud), penyalahgunaan wewenang, kebocoran anggaran, atau benturan kepentingan.\n●Memantau dan mengevaluasi status pelaksanaan komitmen perbaikan (follow-up action plan) yang wajib dijalankan oleh divisi teraudit (auditee).",
    "qualification": "Kualifikasi Jabatan:\n\nMinimal S1 Akuntansi, Keuangan, Manajemen, atau bidang terkait (S2 Keuangan/Audit disukai).\n\nMemiliki sertifikasi profesi audit internasional/nasional yang sah (seperti CIA, CISA, QIA, atau CPA).\n\nPengalaman kerja minimal 10–12 tahun di bidang internal audit korporat atau eksternal audit (diutamakan alumni Big 4 Accounting Firm), dengan minimal 4 tahun di level manajerial audit.",
    "value_chain": "Metodologi Risk-Based Annual Audit Plan (PKAT)",
    "method_cost": 300000000.0
  },
  {
    "code": "1.C.3.1",
    "name": "Internal Audit",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Pelaksana lapangan yang melakukan pengujian, pencocokan bukti fisik, verifikasi transaksi, dan pengumpulan fakta lapangan atas objek audit.\n\nTugas & Tanggung Jawab:\n●Melaksanakan pengujian operasional, keuangan, dan kepatuhan di lapangan berdasarkan program kerja audit yang telah ditetapkan.\n●Mengumpulkan bukti audit yang kompeten, relevan, objektif, dan terdokumentasi dengan kuat dalam Kertas Kerja Audit (KKA).\n●Mengidentifikasi kelemahan sistem dalam pengendalian internal harian serta penyimpangan praktik kerja dari SOP perusahaan.\nMenyusun draf daftar temuan awal dan mendiskusikannya dengan pihak kepala unit operasional lokal untuk proses klarifikasi.",
    "qualification": "Kualifikasi Jabatan: \n\nS1 Akuntansi/Manajemen/Sistem Informasi. Pengalaman kerja 2–5 tahun sebagai Internal Auditor. Memiliki kemampuan berpikir kritis, skeptisisme profesional, objektif, serta menguasai teknik penarikan sampel data (data analytics tools seperti Excel Advance atau ACL).",
    "value_chain": "Software Audit & Data Analytics (ACL/Excel Advanced), Internal Audit Program",
    "method_cost": 8250000000.0
  },
  {
    "code": "1.C.4",
    "name": "VP Pengamanan",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Merancang, menetapkan, dan mengendalikan masterplan pengamanan menyeluruh atas seluruh aset fisik, infrastruktur, personel, dan kelangsungan operasional perusahaan dari ancaman eksternal maupun internal (sabotase, pencurian, penjarahan, huru-hara).\n\nTugas & Tanggung Jawab:\n●Menyusun standardisasi kebijakan dan SOP sistem pengamanan korporat secara nasional di seluruh wilayah kerja/cabang.\n●Membangun, memelihara, dan mengoordinasikan jaringan hubungan strategis dengan aparat penegak hukum negara (Polri, TNI) dan tokoh adat/masyarakat lokal.\n●Memimpin penanggulangan keadaan darurat (Crisis Command Center) saat terjadi aksi unjuk rasa, pendudukan aset, atau gangguan keamanan masif di lapangan.\nMelakukan asesmen risiko keamanan (Security Risk Assessment) secara periodik, terutama pada area operasional yang berisiko tinggi atau wilayah ekspansi baru.",
    "qualification": "Kualifikasi Jabatan:\n \nPurnawirawan TNI/POLRI (minimal pangkat Mayor/Kompol) atau Profesional Sipil dengan sertifikasi Gada Utama yang sah.\n\nPengalaman kerja minimal 10 tahun di bidang manajemen pengamanan korporat (Corporate Security Risk Management), intelijen, atau penegakan hukum operasional perkebunan/pertambangan/manufaktur berskala besar.\n\nMenguasai sistem manajemen krisis, mitigasi konflik sosial kemasyarakatan, serta pengamanan Objek Vital Nasional (Obvitnas).",
    "value_chain": "Sistem Manajemen Krisis & Pengamanan Objek Vital Nasional",
    "method_cost": 300000000.0
  },
  {
    "code": "1.C.4.1",
    "name": "Tim Pengamanan",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Pelaksana garis depan (frontline) yang melakukan pengamanan fisik secara riil, pengawasan area, penegakan tata tertib, dan deteksi dini gangguan keamanan di perimeter perusahaan.\n\nTugas & Tanggung Jawab:\n●Melaksanakan patroli terjadwal, pemeriksaan identitas (access control), serta pemeriksaan logistik/kendaraan keluar-masuk area perusahaan sesuai dengan SOP.\n●Melakukan tindakan pertama pencegahan secara cepat, taktis, dan terukur apabila terjadi pelanggaran keamanan, pencurian, atau potensi bahaya (seperti kebakaran awal).\n●Mengoperasikan dan memantau instrumen pengamanan elektronik (seperti ruang kontrol CCTV, sistem alarm, pagar kejut).\nMenjaga ketertiban pelayanan penerimaan tamu, karyawan, serta memberikan pengawalan melekat jika ada pergerakan aset bernilai tinggi.",
    "qualification": "Kualifikasi Jabatan: \n\nMemiliki sertifikasi minimal Gada Pratama (atau Gada Madya untuk level komandan regu), sehat jasmani & rohani (lolos tes fisik), rekam jejak bersih dari tindak pidana, serta memiliki kedisiplinan dan ketegasan tinggi.",
    "value_chain": "SOP Patroli, Access Control & Sistem CCTV/Alarm",
    "method_cost": 200000000.0
  },
  {
    "code": "1.C.5",
    "name": "VP Information Technology",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Menyelaraskan strategi pengembangan teknologi informasi dengan visi pertumbuhan bisnis perusahaan, memimpin transformasi digital, mengelola alokasi anggaran IT, serta menjamin perlindungan menyeluruh atas keamanan data (cyber security).\n\nTugas & Tanggung Jawab:\n●Merumuskan IT Blueprint / Masterplan Teknologi Informasi jangka panjang korporasi guna mendongkrak efisiensi operasional bisnis.\n●Mengawasi tata kelola pengeluaran anggaran IT (CapEx investasi sistem & OpEx pemeliharaan) agar berjalan efisien secara finansial.\n●Memastikan ketersediaan tinggi (high availability) pada seluruh sistem inti bisnis perusahaan (Core System / ERP) dan merancang Disaster Recovery Plan (DRP) yang andal.\nMenetapkan regulasi tata kelola keamanan siber nasional untuk memitigasi risiko kebocoran data sensitif perusahaan maupun data konsumen.",
    "qualification": "Kualifikasi Jabatan:\n\nMinimal S1 Teknik Informatika, Sistem Informasi, Teknik Komputer, atau Elektro (S2 IT/Business Management disukai).\n\nMemiliki sertifikasi tata kelola/manajemen IT tingkat lanjut (seperti TOGAF, CISM, CISSP, ITIL, atau PMP).\n\nPengalaman kerja minimal 10–12 tahun di bidang teknologi informasi (pengembangan sistem, arsitektur infrastruktur, atau tata kelola siber), dengan minimal 4 tahun di level manajerial IT senior.",
    "value_chain": "IT Blueprint/Master Plan TI & Cyber Security Framework + DRP",
    "method_cost": 700000000.0
  },
  {
    "code": "1.C.5.1",
    "name": "IT",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Menjalankan rekayasa teknis pengembangan sistem, memelihara infrastruktur jaringan, merawat perangkat keras, serta memberikan solusi teknis atas kendala komputasi harian pengguna (user).\n\nTugas & Tanggung Jawab:\n●Melakukan penulisan kode (coding), pengujian modul, perbaikan bug, dan pemeliharaan aplikasi internal perusahaan.\n●Mengonfigurasi, mengoptimalkan, dan memelihara keandalan operasional server pusat/lokal, jaringan internet (LAN/WAN), serta perangkat komputer karyawan.\n●Menyelesaikan keluhan teknis pengguna (troubleshooting ticketing) dengan cepat demi meminimalkan waktu henti operasional kerja (downtime).\nMelakukan proses pencadangan data (data backup) dan sinkronisasi sistem secara berkala sesuai ketentuan tata kelola IT perusahaan.",
    "qualification": "Kualifikasi Jabatan: \n\nS1 Informatika/Sistem Informasi. Menguasai keahlian spesifik fungsional (seperti Network/Infrastructure Engineer, Fullstack/Backend Developer, System Administrator, atau IT Helpdesk Support), serta familier dengan bahasa pemrograman, manajemen basis data, atau topologi jaringan kabel/nirkabel.",
    "value_chain": "Sistem Helpdesk, Network Management & Data Backup, Enterprise Data Warehouse, Business Intelligence",
    "method_cost": 23300000000.0
  },
  {
    "code": "1.D.1",
    "name": "Direktur Wilayah Sumatera",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Memimpin dan mengendalikan operasional secara langsung di lapangan untuk memastikan kelancaran rantai pasok pangan (KSPP), jaringan retail (KDKMP), serta mengawal eksekusi proyek pembangunan fisik dan infrastruktur (Konsultan Engineering) di wilayah teritorialnya.                                                                                                                                                                                                          \n\nTugas & Tanggung Jawab:\n● Melakukan inspeksi dan pengawasan lapangan secara berkesinambungan untuk memastikan operasional retail (KDKMP) dan program ketahanan pangan (KSPP) berjalan sesuai standar perusahaan.\n● Mengawal dan memonitor langsung progres pembangunan fisik, fasilitas logistik, serta eksekusi proyek rekayasa infrastruktur di wilayah kerja.\n● Menjalankan solusi infrastruktur logistik secara taktis di lapangan, termasuk pengelolaan operasional transportasi air untuk menjangkau wilayah pedesaan.\n● Menyelesaikan hambatan teknis dan operasional di lokasi kerja secara cepat, baik yang berkaitan dengan kelancaran distribusi komoditas maupun kendala konstruksi fisik.\n● Melaporkan hasil evaluasi kondisi riil lapangan kepada manajemen pusat serta mengoordinasikan eksekusi harian dengan tim operasional lokal secara formal dan presisi.",
    "qualification": "Kualifikasi Jabatan:\n\n● Pendidikan minimal S1 dari jurusan Teknik (Sipil/Industri), Pertanian, atau Manajemen Operasional.\n● Pengalaman kerja minimal 5–7 tahun, difokuskan pada pengawasan proyek lapangan, operasional logistik, atau manajemen retail yang menuntut mobilitas tinggi.\n● Kesiapan fisik dan mobilitas tinggi untuk secara rutin meninjau kondisi riil di berbagai pelosok wilayah operasional.\n● Memiliki kemampuan membaca dan menganalisis situasi teknis di lapangan, baik untuk kebutuhan rekayasa konstruksi maupun efisiensi rantai pasok.\n● Tegas, praktis dalam pemecahan masalah lapangan (troubleshooting), serta mampu mengawal disiplin eksekusi kerja tim di daerah.",
    "value_chain": "SOP Inspeksi Lapangan KSPP/KDKMP & Sistem Pelaporan Regional",
    "method_cost": 200000000.0
  },
  {
    "code": "1.D.2",
    "name": "Direktur Wilayah Sulawesi",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Memimpin dan mengendalikan operasional secara langsung di lapangan untuk memastikan kelancaran rantai pasok pangan (KSPP), jaringan retail (KDKMP), serta mengawal eksekusi proyek pembangunan fisik dan infrastruktur (Konsultan Engineering) di wilayah teritorialnya.                                                                                                                                                                                                          \n\nTugas & Tanggung Jawab:\n● Melakukan inspeksi dan pengawasan lapangan secara berkesinambungan untuk memastikan operasional retail (KDKMP) dan program ketahanan pangan (KSPP) berjalan sesuai standar perusahaan.\n● Mengawal dan memonitor langsung progres pembangunan fisik, fasilitas logistik, serta eksekusi proyek rekayasa infrastruktur di wilayah kerja.\n● Menjalankan solusi infrastruktur logistik secara taktis di lapangan, termasuk pengelolaan operasional transportasi air untuk menjangkau wilayah pedesaan.\n● Menyelesaikan hambatan teknis dan operasional di lokasi kerja secara cepat, baik yang berkaitan dengan kelancaran distribusi komoditas maupun kendala konstruksi fisik.\n● Melaporkan hasil evaluasi kondisi riil lapangan kepada manajemen pusat serta mengoordinasikan eksekusi harian dengan tim operasional lokal secara formal dan presisi.",
    "qualification": "Kualifikasi Jabatan:\n\n● Pendidikan minimal S1 dari jurusan Teknik (Sipil/Industri), Pertanian, atau Manajemen Operasional.\n● Pengalaman kerja minimal 5–7 tahun, difokuskan pada pengawasan proyek lapangan, operasional logistik, atau manajemen retail yang menuntut mobilitas tinggi.\n● Kesiapan fisik dan mobilitas tinggi untuk secara rutin meninjau kondisi riil di berbagai pelosok wilayah operasional.\n● Memiliki kemampuan membaca dan menganalisis situasi teknis di lapangan, baik untuk kebutuhan rekayasa konstruksi maupun efisiensi rantai pasok.\n● Tegas, praktis dalam pemecahan masalah lapangan (troubleshooting), serta mampu mengawal disiplin eksekusi kerja tim di daerah.",
    "value_chain": "SOP Inspeksi Lapangan KSPP/KDKMP & Sistem Pelaporan Regional",
    "method_cost": 200000000.0
  },
  {
    "code": "1.D.3",
    "name": "Direktur Wilayah Maluku Papua",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Memimpin dan mengendalikan operasional secara langsung di lapangan untuk memastikan kelancaran rantai pasok pangan (KSPP), jaringan retail (KDKMP), serta mengawal eksekusi proyek pembangunan fisik dan infrastruktur (Konsultan Engineering) di wilayah teritorialnya.                                                                                                                                                                                                          \n\nTugas & Tanggung Jawab:\n● Melakukan inspeksi dan pengawasan lapangan secara berkesinambungan untuk memastikan operasional retail (KDKMP) dan program ketahanan pangan (KSPP) berjalan sesuai standar perusahaan.\n● Mengawal dan memonitor langsung progres pembangunan fisik, fasilitas logistik, serta eksekusi proyek rekayasa infrastruktur di wilayah kerja.\n● Menjalankan solusi infrastruktur logistik secara taktis di lapangan, termasuk pengelolaan operasional transportasi air untuk menjangkau wilayah pedesaan.\n● Menyelesaikan hambatan teknis dan operasional di lokasi kerja secara cepat, baik yang berkaitan dengan kelancaran distribusi komoditas maupun kendala konstruksi fisik.\n● Melaporkan hasil evaluasi kondisi riil lapangan kepada manajemen pusat serta mengoordinasikan eksekusi harian dengan tim operasional lokal secara formal dan presisi.",
    "qualification": "Kualifikasi Jabatan:\n\n● Pendidikan minimal S1 dari jurusan Teknik (Sipil/Industri), Pertanian, atau Manajemen Operasional.\n● Pengalaman kerja minimal 5–7 tahun, difokuskan pada pengawasan proyek lapangan, operasional logistik, atau manajemen retail yang menuntut mobilitas tinggi.\n● Kesiapan fisik dan mobilitas tinggi untuk secara rutin meninjau kondisi riil di berbagai pelosok wilayah operasional.\n● Memiliki kemampuan membaca dan menganalisis situasi teknis di lapangan, baik untuk kebutuhan rekayasa konstruksi maupun efisiensi rantai pasok.\n● Tegas, praktis dalam pemecahan masalah lapangan (troubleshooting), serta mampu mengawal disiplin eksekusi kerja tim di daerah.",
    "value_chain": "SOP Inspeksi Lapangan + Solusi Logistik Transportasi Air (wilayah kepulauan)",
    "method_cost": 250000000.0
  },
  {
    "code": "1.D.4",
    "name": "Direktur Wilayah Kalimantan",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Memimpin dan mengendalikan operasional secara langsung di lapangan untuk memastikan kelancaran rantai pasok pangan (KSPP), jaringan retail (KDKMP), serta mengawal eksekusi proyek pembangunan fisik dan infrastruktur (Konsultan Engineering) di wilayah teritorialnya.                                                                                                                                                                                                          \n\nTugas & Tanggung Jawab:\n● Melakukan inspeksi dan pengawasan lapangan secara berkesinambungan untuk memastikan operasional retail (KDKMP) dan program ketahanan pangan (KSPP) berjalan sesuai standar perusahaan.\n● Mengawal dan memonitor langsung progres pembangunan fisik, fasilitas logistik, serta eksekusi proyek rekayasa infrastruktur di wilayah kerja.\n● Menjalankan solusi infrastruktur logistik secara taktis di lapangan, termasuk pengelolaan operasional transportasi air untuk menjangkau wilayah pedesaan.\n● Menyelesaikan hambatan teknis dan operasional di lokasi kerja secara cepat, baik yang berkaitan dengan kelancaran distribusi komoditas maupun kendala konstruksi fisik.\n● Melaporkan hasil evaluasi kondisi riil lapangan kepada manajemen pusat serta mengoordinasikan eksekusi harian dengan tim operasional lokal secara formal dan presisi.",
    "qualification": "Kualifikasi Jabatan:\n\n● Pendidikan minimal S1 dari jurusan Teknik (Sipil/Industri), Pertanian, atau Manajemen Operasional.\n● Pengalaman kerja minimal 5–7 tahun, difokuskan pada pengawasan proyek lapangan, operasional logistik, atau manajemen retail yang menuntut mobilitas tinggi.\n● Kesiapan fisik dan mobilitas tinggi untuk secara rutin meninjau kondisi riil di berbagai pelosok wilayah operasional.\n● Memiliki kemampuan membaca dan menganalisis situasi teknis di lapangan, baik untuk kebutuhan rekayasa konstruksi maupun efisiensi rantai pasok.\n● Tegas, praktis dalam pemecahan masalah lapangan (troubleshooting), serta mampu mengawal disiplin eksekusi kerja tim di daerah.",
    "value_chain": "SOP Inspeksi Lapangan KSPP/KDKMP & Sistem Pelaporan Regional",
    "method_cost": 200000000.0
  },
  {
    "code": "1.D.5",
    "name": "Direktur Wilayah Jawa",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Memimpin dan mengendalikan operasional secara langsung di lapangan untuk memastikan kelancaran rantai pasok pangan (KSPP), jaringan retail (KDKMP), serta mengawal eksekusi proyek pembangunan fisik dan infrastruktur (Konsultan Engineering) di wilayah teritorialnya.                                                                                                                                                                                                          \n\nTugas & Tanggung Jawab:\n● Melakukan inspeksi dan pengawasan lapangan secara berkesinambungan untuk memastikan operasional retail (KDKMP) dan program ketahanan pangan (KSPP) berjalan sesuai standar perusahaan.\n● Mengawal dan memonitor langsung progres pembangunan fisik, fasilitas logistik, serta eksekusi proyek rekayasa infrastruktur di wilayah kerja.\n● Menjalankan solusi infrastruktur logistik secara taktis di lapangan, termasuk pengelolaan operasional transportasi air untuk menjangkau wilayah pedesaan.\n● Menyelesaikan hambatan teknis dan operasional di lokasi kerja secara cepat, baik yang berkaitan dengan kelancaran distribusi komoditas maupun kendala konstruksi fisik.\n● Melaporkan hasil evaluasi kondisi riil lapangan kepada manajemen pusat serta mengoordinasikan eksekusi harian dengan tim operasional lokal secara formal dan presisi.",
    "qualification": "Kualifikasi Jabatan:\n\n● Pendidikan minimal S1 dari jurusan Teknik (Sipil/Industri), Pertanian, atau Manajemen Operasional.\n● Pengalaman kerja minimal 5–7 tahun, difokuskan pada pengawasan proyek lapangan, operasional logistik, atau manajemen retail yang menuntut mobilitas tinggi.\n● Kesiapan fisik dan mobilitas tinggi untuk secara rutin meninjau kondisi riil di berbagai pelosok wilayah operasional.\n● Memiliki kemampuan membaca dan menganalisis situasi teknis di lapangan, baik untuk kebutuhan rekayasa konstruksi maupun efisiensi rantai pasok.\n● Tegas, praktis dalam pemecahan masalah lapangan (troubleshooting), serta mampu mengawal disiplin eksekusi kerja tim di daerah.",
    "value_chain": "SOP Inspeksi Lapangan KSPP/KDKMP & Sistem Pelaporan Regional (kepadatan proyek tertinggi)",
    "method_cost": 200000000.0
  },
  {
    "code": "1.D.6",
    "name": "Direktur Wilayah Bali Nusra",
    "source_sheet": "3. ValueChain & JobDesc",
    "job_description": "Fungsi: Memimpin dan mengendalikan operasional secara langsung di lapangan untuk memastikan kelancaran rantai pasok pangan (KSPP), jaringan retail (KDKMP), serta mengawal eksekusi proyek pembangunan fisik dan infrastruktur (Konsultan Engineering) di wilayah teritorialnya.                                                                                                                                                                                                          \n\nTugas & Tanggung Jawab:\n● Melakukan inspeksi dan pengawasan lapangan secara berkesinambungan untuk memastikan operasional retail (KDKMP) dan program ketahanan pangan (KSPP) berjalan sesuai standar perusahaan.\n● Mengawal dan memonitor langsung progres pembangunan fisik, fasilitas logistik, serta eksekusi proyek rekayasa infrastruktur di wilayah kerja.\n● Menjalankan solusi infrastruktur logistik secara taktis di lapangan, termasuk pengelolaan operasional transportasi air untuk menjangkau wilayah pedesaan.\n● Menyelesaikan hambatan teknis dan operasional di lokasi kerja secara cepat, baik yang berkaitan dengan kelancaran distribusi komoditas maupun kendala konstruksi fisik.\n● Melaporkan hasil evaluasi kondisi riil lapangan kepada manajemen pusat serta mengoordinasikan eksekusi harian dengan tim operasional lokal secara formal dan presisi.",
    "qualification": "Kualifikasi Jabatan:\n\n● Pendidikan minimal S1 dari jurusan Teknik (Sipil/Industri), Pertanian, atau Manajemen Operasional.\n● Pengalaman kerja minimal 5–7 tahun, difokuskan pada pengawasan proyek lapangan, operasional logistik, atau manajemen retail yang menuntut mobilitas tinggi.\n● Kesiapan fisik dan mobilitas tinggi untuk secara rutin meninjau kondisi riil di berbagai pelosok wilayah operasional.\n● Memiliki kemampuan membaca dan menganalisis situasi teknis di lapangan, baik untuk kebutuhan rekayasa konstruksi maupun efisiensi rantai pasok.\n● Tegas, praktis dalam pemecahan masalah lapangan (troubleshooting), serta mampu mengawal disiplin eksekusi kerja tim di daerah.",
    "value_chain": "SOP Inspeksi Lapangan KSPP/KDKMP & Sistem Pelaporan Regional",
    "method_cost": 200000000.0
  }
]
JSON, true, 512, JSON_THROW_ON_ERROR);

        $inserted = 0;
        $skipped = 0;

        foreach ($profiles as $profile) {
            $organization = Organization::query()
                ->where('code', $profile['code'])
                ->first();

            if (! $organization) {
                $skipped++;
                $this->command?->warn("Organization code {$profile['code']} not found. Skipped.");

                continue;
            }

            OrganizationProfile::query()->updateOrCreate(
                [
                    'organization_id' => $organization->id,
                ],
                [
                    'excel_import_id' => null,
                    'source_sheet' => $profile['source_sheet'] ?? '3. ValueChain & JobDesc',
                    'job_description' => $profile['job_description'] ?? null,
                    'qualification' => $profile['qualification'] ?? null,
                    'value_chain' => $profile['value_chain'] ?? null,
                    'method_cost' => $profile['method_cost'] ?? null,
                    'raw_payload' => [
                        'seed_source' => 'WORKSHEE DASHBOARD AGRINAS 260604.xlsx',
                        'sheet' => $profile['source_sheet'] ?? '3. ValueChain & JobDesc',
                        'excel_code' => $profile['code'],
                        'excel_name' => $profile['name'] ?? null,
                    ],
                ]
            );

            $inserted++;
        }

        $this->command?->info("Organization profiles seeded: {$inserted} inserted/updated, {$skipped} skipped.");
    }
}
