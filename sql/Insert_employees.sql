INSERT INTO [dbo].[employees]
           ([username]
           ,[password]
           ,[person_id]
           ,[deleted]
           ,[superuser]
           ,[chpasswd]
           ,[create_dt])
     VALUES
           ('admin'
           ,'21232f297a57a5a743894a0e4a801fc3'
           ,1
           ,0
           ,1
           ,1
           ,GETDATE())
GO


