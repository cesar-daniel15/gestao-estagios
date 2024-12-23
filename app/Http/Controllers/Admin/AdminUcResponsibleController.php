<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution; // Import do Model Institution
use App\Models\Course; // Import do Model Course
use App\Models\UnitCurricular; // Import do Model UnitCurricular
use App\Models\UcResponsible; // Import do Model UcResponsible
use Illuminate\Support\Str; 
use App\Http\Resources\InstitutionResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\UcResponsibleResource; // Import do UcResponsibleResource
use App\Http\Resources\UnitResource; // Import do UnitResource
use Illuminate\Support\Facades\Validator; // Import do Validator
use App\Traits\HttpResponses; // Import do trait HttpResponses
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminUcResponsibleController extends Controller

{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $UcResponsibles = UcResponsible::all();
        $unitCurriculars = UnitCurricular::all();
        $institutions = Institution::all();
        $courses = Course::all();

        return view('admin.uc-responsibles', [
            'UcResponsibles' =>UcResponsibleResource::collection($UcResponsibles)->resolve() ?? [],
            'unitCurriculars' => UnitResource::collection($unitCurriculars)->resolve() ?? [],
            'institutions' => InstitutionResource::collection($institutions)->resolve() ?? [],
            'courses' => CourseResource::collection($courses)->resolve() ?? []
        ]);
    }
    
        

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados enviados via POST
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:9|unique:uc_responsibles,phone,' . $UcResponsible->id,
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validação para a imagem (se for enviada)
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Se uma imagem foi enviada, faz o upload
        $picturePath = null;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('uc_responsibles_pictures', 'public');
        }
    
        // Cria o responsável da UC
        $uc_responsible = UcResponsible::create([
            'phone' => $request->phone,
            'picture' => $picturePath,  // Armazena o caminho da imagem
        ]);

        // Verifica se a criação foi bem-sucedida
        if ($uc_responsible) {
            return redirect()->route('admin.uc_responsibles.index')->with('success', 'Responsável da UC criado com sucesso!');
        } else {
            return redirect()->route('admin.uc_responsibles.index')->with('error', 'Erro ao criar responsável da UC.');
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Encontra o responsável da UC pelo ID
        $UcResponsible =UcResponsible::with(['ucs.course.institution', 'users'])->findOrFail($id);
        
        // Retorna a resposta com os dados do responsável da UC
        return view('admin.uc_responsibles.index', compact('UcResponsible'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UcResponsible $UcResponsible)
    {

        // Validação dos dados enviados via PUT
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:9',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'phone.required' => 'O campo telefone é obrigatório.',
            'phone.max' => 'O telefone não pode ter mais de 9 caracteres.',
            'picture.image' => 'A imagem do perfil deve ser uma imagem válida.',
            'picture.mimes' => 'A imagem deve ser dos tipos: jpeg, png, jpg, gif.',
            'picture.max' => 'A imagem não pode ter mais de 2MB.',
        ]);
    
        // Se a validação falhar, retorna os erros
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $validator->validated();
    
        if ($request->hasFile('picture')) {
            // Apaga a picture antiga
            if ($UcResponsible->picture && Storage::disk('public')->exists($UcResponsible->picture)) {
                Storage::disk('public')->delete($UcResponsible->picture);
            }
        
            // Guarda o novo logo 
            $path = $request->file('picture')->store('images/uploads', 'public');
            $data['picture'] = $path; // Atualiza o caminho no array de dados
        }
    
        // Faz a atualização
        $update = $UcResponsible->update($data);
    
        // Verifica se a atualização foi bem-sucedida
        if ($update) {
            return redirect()->route('admin.uc_responsibles.index')->with('success', 'Responsável da UC atualizado com sucesso!');
        } else {
            return redirect()->route('admin.uc_responsibles.index')->with('error', 'Erro ao atualizar o responsável da UC.');
        }
    }
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UcResponsible $UcResponsible)
    {
        // Remove o responsável da UC
        $delete = $UcResponsible->delete();

        // Retorna uma resposta de sucesso
        if ($delete) {  // Verifica se o delete foi bem-sucedido
            return redirect()->route('admin.uc_responsibles.index')->with('success', 'Responsável da UC excluído com sucesso!');
        } else {
            return redirect()->route('admin.uc_responsibles.index')->with('error', 'Erro ao excluir o responsável da UC.');
        }
    }

    // Associar responsável a uma unidade curricular
    public function associateUc(Request $request, $UcResponsible)
    {
        // Validação simples
        $validator = Validator::make($request->all(), [
            'uc_id' => 'exists:units_curriculars,id',
        ], [
            'uc_id.exists' => 'A Unidade Curricular informada não existe.',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $responsible = UcResponsible::findOrFail($UcResponsible);

        // Verificar se o responsável já tem alguma unidade curricular associada
        if ($responsible->ucs()->count() > 0) {
            return redirect()->back()->withErrors(['uc_id' => 'Este responsável já está associado a uma Unidade Curricular'])->withInput();
        }

        // Verificar se a unidade já tem algum responsável associado
        if (DB::table('uc_to_responsibles')->where('uc_id', $request->uc_id)->exists()) {
            return redirect()->back()->withErrors(['uc_id' => 'Esta Unidade Curricular já possui um responsável associado'])->withInput();
        }

        // Associar a unidade curricular ao responsável
        $responsible->ucs()->attach($request->uc_id);

        return redirect()->route('admin.uc_responsibles.index')->with('success', 'Unidade Curricular associada com sucesso');
    }
}
