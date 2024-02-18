<?php

namespace App\Controller;

use App\Entity\Group;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class GroupController extends AbstractController
{
    const PROPERTY_ID = 'id';
    const PROPERTY_NAME = 'name';
    const PROPERTY_ORIGIN = 'origin';
    const PROPERTY_CITY = 'city';
    const PROPERTY_START_DATE = 'startDate';
    const PROPERTY_END_DATE = 'endDate';
    const PROPERTY_CREATOR = 'creator';
    const PROPERTY_MEMBER = 'member';
    const PROPERTY_MUSICAL_STYLE = 'musicalStyle';
    const PROPERTY_DESCRIPTION = 'description';
    
    public function __construct(private GroupRepository $groupRepository)
    {
    }

    #[Route('/group', name:'group_list', methods: ['GET', 'HEAD'])]
    public function getGroup(EntityManagerInterface $em): Response
    {
        $groups = $em->getRepository(Group::class)->findAll();
        
        $groupsArray = [];
        foreach ($groups as $group) {
            $groupsArray[] = [
                SELF::PROPERTY_ID => $group->getId(),
                SELF::PROPERTY_NAME => $group->getName(),
                SELF::PROPERTY_ORIGIN => $group->getOrigin(),
                SELF::PROPERTY_CITY => $group->getCity(),
                SELF::PROPERTY_START_DATE => $group->getStartDate(),
                SELF::PROPERTY_END_DATE => $group->getEndDate(),
                SELF::PROPERTY_CREATOR => $group->getCreator(),
                SELF::PROPERTY_MEMBER => $group->getMember(),
                SELF::PROPERTY_MUSICAL_STYLE => $group->getMusicalStyle(),
                SELF::PROPERTY_DESCRIPTION => $group->getDescription(),
            ];
        }
        
        return new Response(json_encode($groupsArray));
    }

    #[Route('/group/{id}', name: 'group_show', methods: ["GET","OPTIONS"])]
    public function getGroupById($id, EntityManagerInterface $em)
    {
        $group = $em->getRepository(Group::class)->find($id);
        
        if (!$group) {
            return new JsonResponse('Group not found', 404);
        }

        $groupArray = [
            SELF::PROPERTY_ID => $group->getId(),
            SELF::PROPERTY_NAME => $group->getName(),
            SELF::PROPERTY_ORIGIN => $group->getOrigin(),
            SELF::PROPERTY_CITY => $group->getCity(),
            SELF::PROPERTY_START_DATE => $group->getStartDate(),
            SELF::PROPERTY_END_DATE => $group->getEndDate(),
            SELF::PROPERTY_CREATOR => $group->getCreator(),
            SELF::PROPERTY_MEMBER => $group->getMember(),
            SELF::PROPERTY_MUSICAL_STYLE => $group->getMusicalStyle(),
            SELF::PROPERTY_DESCRIPTION => $group->getDescription(),
        ];

        return new JsonResponse(json_encode($groupArray), 200, [], true);
        
    }

    #[Route('/group/create', name:'group_create', methods: ['GET', 'POST',"OPTIONS"])]
    public function createGroup(Request $request, EntityManagerInterface $em): Response
    {
        // Get the file from the sent request
        $file = $request->files->get('file');
        // The folder in which the uploaded file will be stored
        $fileFolder = $this->getParameter('kernel.project_dir') . '/public/uploads/'; 
        // Generate a unique identifier for the file and concatenate it with the file extension using md5 function
        $filePathName = md5(uniqid()) . '.' . $file->getClientOriginalExtension(); 
        
        try {
            $file->move($fileFolder, $filePathName);
        } catch (FileException $e) {
            return $this->json('groups file not registered', 400); 
        }
        // Read the excel file
        $spreadsheet = IOFactory::load($fileFolder . $filePathName); 
        // Remove the first row
        $spreadsheet->getActiveSheet()->removeRow(1); 
        // Read data into an array
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); 
        
        foreach ($sheetData as $Row) 
        { 
            $name = $Row['A'];  
            $origin = $Row['B']; 
            $city= $Row['C'];     
            $startDate = $Row['D'];
            $endDate = $Row['E'];
            $creator = $Row['F'];
            $member = $Row['G'];
            $musicalStyle = $Row['H'];
            $description = $Row['I'];

            $group = new Group();
            $group->setName($name);
            $group->setOrigin($origin);
            $group->setCity($city);
            $group->setStartDate($startDate);
            $group->setEndDate($endDate);
            $group->setCreator($creator);
            $group->setMember($member);
            $group->setMusicalStyle($musicalStyle);
            $group->setDescription($description);

            $em->persist($group);
        }
        $em->flush();

        return new JsonResponse($group);
    }

    #[Route('/group/update/{id}', name:'groupe_update', methods: ['PUT'])]
    public function updateGroup(Request $request, EntityManagerInterface $em, int $id): Response
    {
        $group = $em->getRepository(Group::class)->find($id);
        $data = json_decode($request->getContent(), true);
        
        if (!$group) {
            return new JsonResponse('Group not found', 404);
        }
        $group->setName($data[SELF::PROPERTY_NAME]);
        $group->setOrigin($data[SELF::PROPERTY_ORIGIN]);
        $group->setCity($data[SELF::PROPERTY_CITY]);
        $group->setStartDate($data[SELF::PROPERTY_START_DATE]);
        $group->setEndDate($data[SELF::PROPERTY_END_DATE]);
        $group->setCreator($data[SELF::PROPERTY_CREATOR]);
        $group->setMember($data[SELF::PROPERTY_MEMBER]);
        $group->setMusicalStyle($data[SELF::PROPERTY_MUSICAL_STYLE]);
        $group->setDescription($data[SELF::PROPERTY_DESCRIPTION]);

        $em->flush();

        return new JsonResponse('Group updated successfully', 200);
    }

    #[Route('/group/delete/{id}', name:'deleteGroup', methods: ["DELETE"])]
    public function deleteGroup(EntityManagerInterface $em, int $id): Response
    {
        $group = $em->getRepository(Group::class)->find($id);
        
        if (!$group) {
            return new JsonResponse('Group not found', 404);
        }
        
        $em->remove($group);
        $em->flush();

        return new JsonResponse('Group deleted', 200);
    }
}