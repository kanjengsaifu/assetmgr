SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[permissions](
	[module_id] [varchar](100) NULL,
	[person_id] [int] NULL
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[permissions]  WITH CHECK ADD  CONSTRAINT [FK_permissions_modules] FOREIGN KEY([module_id])
REFERENCES [dbo].[modules] ([module_id])
GO

ALTER TABLE [dbo].[permissions] CHECK CONSTRAINT [FK_permissions_modules]
GO

ALTER TABLE [dbo].[permissions]  WITH CHECK ADD  CONSTRAINT [FK_permissions_people] FOREIGN KEY([person_id])
REFERENCES [dbo].[people] ([person_id])
GO

ALTER TABLE [dbo].[permissions] CHECK CONSTRAINT [FK_permissions_people]
GO